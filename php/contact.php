<?php
header('Content-Type: application/json');
require 'config.php';

// Replace with your actual reCAPTCHA Secret Key in the live code
const RECAPTCHA_SECRET_KEY = '6LeHxUArAAAAAJ0q47sgqVStSVG0P0i8bsbzHDwj'; 
const RECAPTCHA_THRESHOLD = 0.5; // Score threshold for reCAPTCHA v3 (0.0 to 1.0)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Honeypot check
    if (!empty($_POST["contact_website"])) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Thank you for your inquiry!"]);
        exit;
    }

    // Sanitize and validate form data
    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $recaptcha_token = $_POST['recaptcha_token'] ?? '';

    // Basic form validation
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required and email must be valid.']);
        exit;
    }

    // reCAPTCHA verification
    if (empty($recaptcha_token)) {
        error_log("reCAPTCHA token missing in contact form submission for email: " . $email);
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'reCAPTCHA verification failed.']);
        exit;
    }

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_response_data = [
        'secret' => RECAPTCHA_SECRET_KEY,
        'response' => $recaptcha_token,
        'remoteip' => $_SERVER['REMOTE_ADDR'] // Include client IP for better reCAPTCHA accuracy
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $recaptcha_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($recaptcha_response_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Ensure SSL verification is enabled
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout to avoid hanging
    $recaptcha_response = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        error_log("cURL error during reCAPTCHA verification: " . $curl_error);
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server error during reCAPTCHA verification. Please try again.']);
        exit;
    }

    $recaptcha_data = json_decode($recaptcha_response);
    if (!$recaptcha_data || !$recaptcha_data->success || $recaptcha_data->score < RECAPTCHA_THRESHOLD) {
        error_log("reCAPTCHA verification failed for email: " . $email .
                  " Score: " . ($recaptcha_data->score ?? 'N/A') .
                  " Success: " . ($recaptcha_data->success ? 'true' : 'false') .
                  " Error Codes: " . json_encode($recaptcha_data->{'error-codes'} ?? 'N/A'));
        http_response_code(200);
        echo json_encode(["success" => false, "message" => "Thank you for your inquiry!"]);
        exit;
    }

    // Email sending logic
    $subject = 'New Contact Inquiry';
    $body = "Subject: New Contact Form Submission\n\n"
          . "Dear BizlyHub Team,\n\n"
          . "A potential client has submitted the following details through our website's contact form:\n\n"
          . "Name: " . htmlspecialchars($name) . "\n"
          . "Email: " . htmlspecialchars($email) . "\n"
          . "Message: " . htmlspecialchars($message) . "\n\n"
          . "Please follow up with them at your earliest convenience.\n\n"
          . "Best regards,\n"
          . "BizlyHub Team";

    $recipients = [
        'joseph.peralta03011993@gmail.com',
        'jhelyntesiorna02@gmail.com',
        'payumojohnniere8@gmail.com',
        'riarencs@gmail.com'
    ];

    if (function_exists('sendEmail')) {
        if (sendEmail($recipients, $subject, $body)) {
            http_response_code(200);
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
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>