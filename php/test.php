<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include PHPMailer files
require 'src/PHPMailer.php';
require 'src/SMTP.php';
require 'src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Enable verbose debug output
    $mail->SMTPDebug = 2; // 2 = detailed debug
    $mail->Debugoutput = 'echo'; // Output to screen

    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'joseph.peralta03011993@gmail.com';
    $mail->Password = 'grsc ygyr nygm lnuz'; // Replace with correct 16-char App Password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('joseph.peralta03011993@gmail.com', 'BizlyHub');
    $mail->addAddress('joseph.peralta03011993@gmail.com'); // Test to yourself first

    // Content
    $mail->isHTML(false);
    $mail->Subject = 'Test Email from BizlyHub';
    $mail->Body = 'This is a test email to verify PHPMailer works.';

    $mail->send();
    echo 'Email sent successfully!';
} catch (Exception $e) {
    echo "Email failed to send. Error: {$mail->ErrorInfo}";
}
?>