<?php
header('Content-Type: application/json');
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

    if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $subject = 'New Newsletter Subscriber';
        $body = "New subscriber: $email";

        // Array of recipients
        $recipients = [
            'joseph.peralta03011993@gmail.com',
            'jhelyntesiorna02@gmail.com',
            'payumojohnniere8@gmail.com'
        ];

        if (sendEmail($recipients, $subject, $body)) {
            echo json_encode(['message' => 'Subscribed successfully!']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Error subscribing. Please try again.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid email address.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed.']);
}
?>