<?php
// Require PHPMailer files (place the 'src' folder from PHPMailer in the same directory)
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);
    
    // Set the recipient email address (your email)
    $to = 'arpanlogy@gmail.com';  // Replace with your actual email if different
    
    // Set the email subject
    $subject = 'New Contact Form Submission from ' . $name;
    
    // Build the email content
    $body = "Name: $name\n"
          . "Email: $email\n"
          . "Message:\n$message";
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings for Gmail
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'arpanlogy@gmail.com'; // Replace with your Gmail address
        $mail->Password = 'dnta upqw ewlb vzsv'; // Replace with your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        // Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress($to);
    
        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;
    
        // Send the email
        $mail->send();
        echo 'Message sent successfully!';
    } catch (Exception $e) {
        echo "Error sending message: {$mail->ErrorInfo}";
    }
} else {
    echo 'Invalid request.';
}