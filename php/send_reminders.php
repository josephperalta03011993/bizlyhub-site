<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bizlyhub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    exit;
}

$today_day = (int) date('j'); // Current day of month (1-31)
$stmt = $conn->prepare("SELECT name, due_date, email FROM bills WHERE notify_day = ? AND notifications = TRUE");
$stmt->bind_param("i", $today_day);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $subject = "Bill Reminder: {$row['name']}";
    $body = "<p>Reminder: Your <strong>{$row['name']}</strong> bill is due on day {$row['due_date']} of this month.</p>";
    $body .= "<p>Please ensure payment is made on time to avoid late fees.</p>";
    $body .= "<p>Manage your reminders at <a href='https://yourwebsite.com'>yourwebsite.com</a>.</p>";
    
    $recipients = [$row['email']];
    if (sendEmailNotifications($recipients, $subject, $body)) {
        error_log("Reminder sent for {$row['name']} to {$row['email']}");
    } else {
        error_log("Failed to send reminder for {$row['name']} to {$row['email']}");
    }
}

$stmt->close();
$conn->close();

/**
 * Send notification emails to recipients
 *
 * @param array $recipients Array of email addresses
 * @param string $subject Email subject
 * @param string $body Email body
 * @return bool Whether emails were sent successfully
 */
function sendEmailNotifications($recipients, $subject, $body) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Bill Reminder <noreply@yourwebsite.com>" . "\r\n";

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