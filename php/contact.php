<?php
header('Content-Type: application/json');
require 'config.php';

// Add your reCAPTCHA Secret Key here
// REPLACE THIS WITH YOUR ACTUAL SECRET KEY FROM GOOGLE
const RECAPTCHA_SECRET_KEY = '6LeHxUArAAAAAJ0q47sgqVStSVG0P0i8bsbzHDwj';
const RECAPTCHA_THRESHOLD = 0.5; // Adjust this value (0.0 to 1.0). 0.5 is a common starting point.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING);
    $recaptcha_token = $_POST['recaptcha_token'] ?? ''; // Get the reCAPTCHA token

    // --- Honeypot Check (Keep this, it's a good first filter) ---
    if (!empty($_POST["contact_website"])) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Thank you for your inquiry!"]);
        exit;
    }

    // --- reCAPTCHA Verification ---
    if (empty($recaptcha_token)) {
        http_response_code(400);
        echo json_encode(['message' => 'reCAPTCHA token missing.']);
        exit;
    }

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_response = file_get_contents($recaptcha_url . '?secret=' . RECAPTCHA_SECRET_KEY . '&response=' . $recaptcha_token);
    $recaptcha_data = json_decode($recaptcha_response);

    if (!$recaptcha_data->success || $recaptcha_data->score < RECAPTCHA_THRESHOLD) {
        // Log this attempt for analysis if you wish, it's likely a bot
        error_log("reCAPTCHA failed for email: " . $email . " Score: " . ($recaptcha_data->score ?? 'N/A') . " Success: " . ($recaptcha_data->success ? 'true' : 'false'));

        http_response_code(403); // Forbidden, or 200 with generic success message for bots
        // For bots, you might still return a success message to avoid tipping them off:
        echo json_encode(["success" => false, "message" => "Thank you for your inquiry!"]); // Or "Submission failed reCAPTCHA check."
        exit;
    }

    // --- Original Form Processing (Only proceeds if honeypot and reCAPTCHA pass) ---
    if (!empty($name) && !empty($email) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $subject = 'New Contact Inquiry';
        $body = "Subject: New Contact Form Submission\n\n"
              . "Dear Bizlyhub Team,\n\n"
              . "A potential client has submitted the following details through our website's contact form:\n\n"
              . "Name: " . htmlspecialchars($name) . "\n"
              . "Email: " . htmlspecialchars($email) . "\n"
              . "Message: " . htmlspecialchars($message) . "\n\n"
              . "Please follow up with them at your earliest convenience.\n\n"
              . "Best regards,\n"
              . "Bizlyhub Team";

        // Array of recipients
        $recipients = [
            'joseph.peralta03011993@gmail.com',
            'jhelyntesiorna02@gmail.com',
            'payumojohnniere8@gmail.com',
            'riarencs@gmail.com'
        ];

        // Ensure sendEmail function is correctly defined or included from config.php
        if (function_exists('sendEmail')) { // Check if sendEmail exists, if it's in config.php
            if (sendEmail($recipients, $subject, $body)) {
                echo json_encode(['success' => true, 'message' => 'Inquiry sent successfully!']);
            } else {
                error_log("Failed to send contact inquiry email for: " . $email);
                http_response_code(500);
                echo json_encode(['success' => false, 'message' => 'Error sending inquiry. Please try again.']);
            }
        } else {
            error_log("sendEmail function not found in contact.php. Check config.php inclusion.");
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Server configuration error.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required and email must be valid.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>