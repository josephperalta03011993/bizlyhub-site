<?php

header('Content-Type: application/json');
require 'config.php';

// IMPORTANT: Replace 'YOUR_ACTUAL_RECAPTCHA_SECRET_KEY' with the Secret Key you got from Google.
// This key must be kept absolutely secret and should NOT be in your public HTML.
const RECAPTCHA_SECRET_KEY = '6LeHxUArAAAAAJ0q47sgqVStSVG0P0i8bsbzHDwj'; 
const RECAPTCHA_THRESHOLD = 0.5; // Adjust this value (0.0 to 1.0). 0.5 is a common starting point.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Honeypot Check (FIRST and FASTEST filter) ---
    if (!empty($_POST["contact_website"])) {
        // This is a bot. Return success to avoid tipping off the bot.
        http_response_code(200); // OK status
        echo json_encode(["success" => true, "message" => "Thank you for your inquiry!"]); // Generic success message
        exit; // STOP script execution immediately
    }

    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING);
    $recaptcha_token = $_POST['recaptcha_token'] ?? ''; // Get the reCAPTCHA token

    // --- reCAPTCHA Verification ---
    if (empty($recaptcha_token)) {
        error_log("reCAPTCHA token missing in contact form submission for email: " . $email);
        http_response_code(400); // Bad Request (for a missing token, this is appropriate)
        echo json_encode(['success' => false, 'message' => 'reCAPTCHA verification failed.']); // Specific error for debugging
        exit; // STOP script execution
    }

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_response_data = [
        'secret' => RECAPTCHA_SECRET_KEY,
        'response' => $recaptcha_token
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $recaptcha_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($recaptcha_response_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $recaptcha_response = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        error_log("cURL error during reCAPTCHA verification: " . $curl_error);
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Server error during reCAPTCHA verification. Please try again.']);
        exit;
    }

    $recaptcha_data = json_decode($recaptcha_response);

    // CRITICAL: Check reCAPTCHA verification results
    // If reCAPTCHA fails, return a "Thank you for your inquiry!" message but do NOT send the email.
    // This makes bots think they succeeded, preventing them from adapting.
    if (!$recaptcha_data || !$recaptcha_data->success || $recaptcha_data->score < RECAPTPTCHA_THRESHOLD) {
        error_log("reCAPTCHA verification failed for email: " . $email .
                  " Score: " . ($recaptcha_data->score ?? 'N/A') .
                  " Success: " . ($recaptcha_data->success ? 'true' : 'false') .
                  " Error Codes: " . json_encode($recaptcha_data->{'error-codes'} ?? 'N/A'));

        // For bots, return a success message (to the user via AJAX) to avoid tipping them off.
        // But the 'success' flag for JS will be false, indicating no actual email sent.
        http_response_code(200); // OK status
        echo json_encode(["success" => false, "message" => "Thank you for your inquiry!"]); // Generic success message for the user, but internally failed
        exit; // STOP script execution immediately for failed reCAPTCHA
    }

    // --- Basic Form Data Validation (Only proceeds if honeypot and reCAPTCHA pass) ---
    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'All fields are required and email must be valid.']);
        exit; // STOP script execution
    }

    // --- Email Sending Logic (Only reached if all checks pass) ---
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

    $recipients = [
        'joseph.peralta03011993@gmail.com',
        'jhelyntesiorna02@gmail.com',
        'payumojohnniere8@gmail.com',
        'riarencs@gmail.com'
    ];

    if (function_exists('sendEmail')) {
        if (sendEmail($recipients, $subject, $body)) {
            http_response_code(200); // Always return 200 OK for successful email sends
            echo json_encode(['success' => true, 'message' => 'Inquiry sent successfully!']);
        } else {
            error_log("Failed to send contact inquiry email for: " . $email);
            http_response_code(500); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Error sending inquiry. Please try again.']);
        }
    } else {
        error_log("sendEmail function not found in contact.php. Check config.php inclusion.");
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Server configuration error.']);
    }

} else {
    // Not a POST request
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
}
?>