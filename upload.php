<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$name = $_POST['name'];
$email = $_POST['email'];
$userMessage = $_POST['message'];

$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // SMTP server
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kuldip18jayswal@gmail.com'; // Your Gmail
    $mail->Password   = '112233';   // Use App Password (not your Gmail password)
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    //Recipients
    $mail->setFrom('yourgmail@gmail.com', 'Internship Uploader');
    $mail->addAddress('receiver@example.com'); // Your receiving email

    // Content
    $mail->isHTML(false);
    $mail->Subject = "Internship Submission from $name";
    
    $body  = "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$userMessage\n\n";

    // Handle file attachments
    if (!empty($_FILES['files']['name'][0])) {
        $total = count($_FILES['files']['name']);
        for ($i = 0; $i < $total; $i++) {
            $tmpFile = $_FILES['files']['tmp_name'][$i];
            $filename = $_FILES['files']['name'][$i];
            $mail->addAttachment($tmpFile, $filename);
        }
    }

    $mail->Body = $body;
    $mail->send();
    echo "<h2>Thank you! Your submission has been emailed successfully.</h2>";

} catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
}
