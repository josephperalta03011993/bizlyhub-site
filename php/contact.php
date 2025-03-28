<?php
header('Content-Type: application/json');
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING);

    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $subject = 'New Contact Inquiry';
        $body = "Subject: New Contact Form Submission

        Dear Bizlyhub Team,

        A potential client has submitted the following details through our website's contact form:

        Name: $name
        Email: $email
        Message: $message

        Please follow up with them at your earliest convenience.

        Best regards,
        Bizlyhub Team";

        // Array of recipients
        $recipients = [
            'joseph.peralta03011993@gmail.com',
            'jhelyntesiorna02@gmail.com',
            'payumojohnniere8@gmail.com'
        ];

        if (sendEmail($recipients, $subject, $body)) {
            echo json_encode(['message' => 'Inquiry sent successfully!']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error sending inquiry. Please try again.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'All fields are required and email must be valid.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed.']);
}
?>