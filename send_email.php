<?php
// Allow requests from your HTML file
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

// Get the JSON data sent from JavaScript
$data = json_decode(file_get_contents("php://input"));

if (!empty($data->email) && !empty($data->theme) && !empty($data->imageUrl)) {
    $to = $data->email;
    $theme = htmlspecialchars($data->theme);
    $imageUrl = htmlspecialchars($data->imageUrl);
    
    // --- ADD YOUR SENDER EMAIL HERE ---
    $from_email = "arpanlogy@gmail.com"; 
    
    $subject = "A Digital Postcard for you: " . $theme;
    
    // Build the HTML email content
    $message = '
    <html>
    <head>
      <title>Digital Postcard</title>
    </head>
    <body style="font-family: Arial, sans-serif; text-align: center; padding: 20px;">
        <div style="max-width: 500px; margin: auto; border: 1px solid #ddd; padding: 20px; border-radius: 10px; background-color: #f4f7f6;">
            <h2 style="color: #D4AC0D;">Greetings!</h2>
            <img src="'.$imageUrl.'" alt="'.$theme.'" style="width: 100%; max-width: 400px; border-radius: 8px;">
            <p style="font-size: 16px; font-style: italic; color: #555; margin-top: 20px;">
                I hope this postcard finds you well. I couldn\'t resist sending you this beautiful view of '.$theme.'. Wish you were here to see it!
            </p>
        </div>
    </body>
    </html>
    ';

    // Set standard email headers for HTML content
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: <" . $from_email . ">" . "\r\n";

    // Send the email
    if(mail($to, $subject, $message, $headers)) {
        http_response_code(200);
        echo json_encode(array("status" => "success"));
    } else {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Mail server failed to send."));
    }
} else {
    // Missing data
    http_response_code(400);
    echo json_encode(array("status" => "error", "message" => "Incomplete data sent to server."));
}
?>
