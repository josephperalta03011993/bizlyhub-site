<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Set Manila time zone
date_default_timezone_set('Asia/Manila');

require_once 'conn.php';
require_once '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

try {
    $current_day = (int)date('j');
    $current_time = date('Y-m-d H:i:s');
    error_log("Running send_notifications on day $current_day at $current_time (Asia/Manila)");
    echo "Running send_notifications on day $current_day at $current_time (Asia/Manila)\n";

    $stmt = $conn->prepare("SELECT id, name, due_date, emails FROM bills WHERE notifications = 1 AND notify_day = ?");
    if (!$stmt) {
        $error = "Prepare failed: " . $conn->error;
        error_log($error);
        echo "$error\n";
        exit;
    }
    $stmt->bind_param("i", $current_day);
    $stmt->execute();
    $result = $stmt->get_result();
    error_log("Found {$result->num_rows} bills with notify_day=$current_day and notifications=1");
    echo "Found {$result->num_rows} bills with notify_day=$current_day and notifications=1\n";

    if ($result->num_rows === 0) {
        error_log("No bills to process.");
        echo "No bills to process.\n";
        $stmt->close();
        $conn->close();
        ob_end_clean();
        exit;
    }

    $mailer = new PHPMailer(true);
    $mailer->isSMTP();
    $mailer->Host = 'smtp.gmail.com';
    $mailer->SMTPAuth = true;
    $mailer->Username = 'your_email@gmail.com'; // Replace with your email
    $mailer->Password = 'your_app_password'; // Replace with your App Password
    $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mailer->Port = 587;
    $mailer->setFrom('your_email@gmail.com', 'BizlyHub Bill Reminder');
    error_log("SMTP configured for {$mailer->Username}");
    echo "SMTP configured for {$mailer->Username}\n";

    $sent_emails = 0;
    while ($row = $result->fetch_assoc()) {
        error_log("Processing bill {$row['id']}: {$row['name']} with emails: {$row['emails']}");
        echo "Processing bill {$row['id']}: {$row['name']} with emails: {$row['emails']}\n";
        $emails = array_map('trim', explode(',', $row['emails']));
        $emails = array_filter($emails, fn($email) => filter_var($email, FILTER_VALIDATE_EMAIL));

        if (empty($emails)) {
            error_log("No valid emails for bill {$row['id']}: {$row['emails']}");
            echo "No valid emails for bill {$row['id']}: {$row['emails']}\n";
            continue;
        }

        $mailer->Subject = "Bill Reminder: {$row['name']} Due on Day {$row['due_date']}";
        $mailer->Body = "Hello,\n\nThis is a reminder that your bill '{$row['name']}' is due on day {$row['due_date']} of the month.\n\nRegards,\nBizlyHub Team";
        $mailer->AltBody = $mailer->Body;
        error_log("Prepared email for bill {$row['id']}: Subject={$mailer->Subject}");
        echo "Prepared email for bill {$row['id']}: Subject={$mailer->Subject}\n";

        foreach ($emails as $email) {
            try {
                $mailer->addAddress($email);
                $mailer->send();
                error_log("Sent reminder for bill {$row['id']} to $email");
                echo "Sent reminder for bill {$row['id']} to $email\n";
                $sent_emails++;
            } catch (Exception $e) {
                error_log("Failed to send to $email for bill {$row['id']}: {$mailer->ErrorInfo}");
                echo "Failed to send to $email for bill {$row['id']}: {$mailer->ErrorInfo}\n";
            }
            $mailer->clearAddresses();
        }
    }

    error_log("Completed: Sent $sent_emails email reminders on day $current_day");
    echo "Completed: Sent $sent_emails email reminders on day $current_day\n";
    $stmt->close();
} catch (Exception $e) {
    error_log("Exception in send_notifications: {$e->getMessage()}");
    echo "Exception in send_notifications: {$e->getMessage()}\n";
}

$conn->close();
ob_end_clean();
?>