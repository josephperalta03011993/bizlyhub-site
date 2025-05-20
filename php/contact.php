<?php
header('Content-Type: application/json');
require 'config.php';

// IMPORTANT: Replace 'YOUR_ACTUAL_RECAPTCHA_SECRET_KEY' with the Secret Key you got from Google.
// This key must be kept absolutely secret and should NOT be in your public HTML.
const RECAPTCHA_SECRET_KEY = '6LeHxUArAAAAAJ0q47sgqVStSVG0P0i8bsbzHDwj'; 
const RECAPTCHA_THRESHOLD = 0.5; // Adjust this value (0.0 to 1.0). 0.5 is a common starting point.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- Honeypot Check (FIRST and FASTEST filter) ---
    // This should always be the very first check to quickly filter out unsophisticated bots.
    if (!empty($_POST["contact_website"])) {
        // Log this if you want, but for bots, just send a success message to avoid tipping them off.
        http_response_code(200); // Return 200 OK to the bot
        echo json_encode(["success" => true, "message" => "Thank you for your inquiry!"]);
        exit; // STOP script execution immediately for bots
    }

    $name = filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'] ?? '', FILTER_SANITIZE_STRING);
    $recaptcha_token = $_POST['recaptcha_token'] ?? ''; // Get the reCAPTCHA token

    // --- reCAPTCHA Verification ---
    // Check if the token is missing from the client-side
    if (empty($recaptcha_token)) {
        // This is a strong indicator of a bot or a problem with the client-side JS
        error_log("reCAPTCHA token missing in contact form submission for email: " . $email);
        http_response_code(400); // Bad Request, but for bots, you might send 200 OK
        echo json_encode(['success' => false, 'message' => 'reCAPTCHA verification failed.']); // Generic message for security
        // Or for bots, to avoid tipping them off: echo json_encode(["success" => true, "message" => "Thank you for your inquiry!"]);
        exit; // STOP script execution immediately
    }

    // Verify reCAPTCHA token with Google
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_response_data = [
        'secret' => RECAPTCHA_SECRET_KEY,
        'response' => $recaptcha_token
    ];

    // Using cURL for more reliable external requests than file_get_contents for POST data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $recaptcha_url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($recaptcha_response_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $recaptcha_response = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        // Handle cURL errors (e.g., network issues)
        error_log("cURL error during reCAPTCHA verification: " . $curl_error);
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => 'Server error during reCAPTCHA verification. Please try again.']);
        exit;
    }

    $recaptcha_data = json_decode($recaptcha_response);

    // This is the CRITICAL missing check for reCAPTCHA failure
    if (!$recaptcha_data || !$recaptcha_data->success || $recaptcha_data->score < RECAPTCHA_THRESHOLD) {
        // Log this attempt for analysis (you can check $recaptcha_data->{'error-codes'} for more info)
        error_log("reCAPTCHA verification failed for email: " . $email . 
                  " Score: " . ($recaptcha_data->score ?? 'N/A') . 
                  " Success: " . ($recaptcha_data->success ? 'true' : 'false') .
                  " Error Codes: " . json_encode($recaptcha_data->{'error-codes'} ?? 'N/A'));

        http_response_code(403); // Forbidden, or 200 with generic success message for bots
        // For bots, you might still return a success message to avoid tipping them off:
        echo json_encode(["success" => false, "message" => "Thank you for your inquiry!"]); // Or "Submission failed reCAPTCHA check."
        exit; // STOP script execution immediately for failed reCAPTCHA
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
        if (function_exists('sendEmail')) {
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