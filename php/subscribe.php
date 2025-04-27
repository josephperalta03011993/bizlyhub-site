<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

// Server connection
// 8d$Z[1Dm
// u414060592_landing
// u414060592_landing

// Database connection
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "bizlyhub";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log error to server logs rather than displaying to user
    error_log("Connection failed: " . $conn->connect_error);
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Unable to connect to the database."]);
    exit;
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    $email = filter_var($_POST["email"] ?? '', FILTER_VALIDATE_EMAIL);

    if (!$email) {
        echo json_encode(["success" => false, "message" => "Invalid email format."]);
        exit;
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO subscriber_email (email, subscribe_date) VALUES (?, NOW())");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        echo json_encode(["success" => false, "message" => "Error preparing database query."]);
        exit;
    }

    $stmt->bind_param("s", $email);

    // Execute the statement
    if ($stmt->execute()) {
        // Database insertion successful, now send notification emails
        $subject = 'New Newsletter Subscriber';
        $body = "<p>A new user has subscribed to the newsletter:</p>";
        $body .= "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
        $body .= "<p><strong>Subscription Date:</strong> " . date("Y-m-d H:i:s") . "</p>";

        // Array of recipients
        $recipients = [
            'joseph.peralta03011993@gmail.com',
            'jhelyntesiorna02@gmail.com',
            'payumojohnniere8@gmail.com',
            'riarencs@gmail.com'
        ];

        $success = sendEmailNotifications($recipients, $subject, $body);

        if ($success) {
            echo json_encode(["success" => true, "message" => "Thank you for subscribing!"]);
        } else {
            // Email sending failed, but database insertion succeeded
            error_log("Failed to send notification emails for: " . $email);
            echo json_encode(["success" => true, "message" => "Thank you for subscribing!"]);
        }
    } else {
        // Check if it's a duplicate email error
        if ($conn->errno == 1062) { // MySQL duplicate entry error code
            echo json_encode(["success" => false, "message" => "This email is already subscribed."]);
        } else {
            error_log("Execute failed: " . $stmt->error);
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Error saving your subscription."]);
        }
    }

    $stmt->close();
}

$conn->close();

/**
 * Send notification emails to admins
 *
 * @param array $recipients Array of email addresses
 * @param string $subject Email subject
 * @param string $body Email body
 * @return bool Whether emails were sent successfully
 */
function sendEmailNotifications($recipients, $subject, $body) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: BizlyHub <noreply@bizlyhub.com>" . "\r\n";

    $allSent = true;

    foreach ($recipients as $recipient) {
        $success = mail($recipient, $subject, $body, $headers);
        if (!$success) {
            error_log("Failed to send email to: " . $recipient);
            $allSent = false;
        }
    }

    return $allSent;
}
?>