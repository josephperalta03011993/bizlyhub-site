<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bizlyhub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    ob_end_flush();
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    error_log("Invalid JSON input: " . file_get_contents('php://input'));
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
    ob_end_flush();
    exit;
}

$id = $input['id'] ?? '';
$name = htmlspecialchars($input['name'] ?? '', ENT_QUOTES, 'UTF-8');
$due_date = filter_var($input['due_date'] ?? 0, FILTER_VALIDATE_INT);
$notify_day = filter_var($input['notify_day'] ?? 0, FILTER_VALIDATE_INT);
$emails = $input['emails'] ?? '';

// Validate inputs
if (!$name || !$due_date || !$notify_day || !$emails || $due_date < 1 || $due_date > 31 || $notify_day < 1 || $notify_day > 31) {
    error_log("Validation failed: name=$name, due_date=$due_date, notify_day=$notify_day, emails=$emails");
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid input data. Ensure all fields are filled correctly."]);
    ob_end_flush();
    exit;
}

// Validate emails
$email_array = array_map('trim', explode(',', $emails));
$email_array = array_filter($email_array);
if (empty($email_array) || !array_reduce($email_array, fn($carry, $email) => $carry && filter_var($email, FILTER_VALIDATE_EMAIL), true)) {
    error_log("Invalid emails: $emails");
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "One or more invalid email addresses."]);
    ob_end_flush();
    exit;
}
$emails = implode(', ', $email_array); // Normalize

try {
    if ($id) {
        $stmt = $conn->prepare("UPDATE bills SET name = ?, due_date = ?, notify_day = ?, emails = ? WHERE id = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
            ob_end_flush();
            exit;
        }
        $stmt->bind_param("siiss", $name, $due_date, $notify_day, $emails, $id);
        $message = "Bill updated successfully!";
    } else {
        $id = bin2hex(random_bytes(16));
        $stmt = $conn->prepare("INSERT INTO bills (id, name, due_date, notify_day, emails) VALUES (?, ?, ?, ?, ?)");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            http_response_code(500);
            echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
            ob_end_flush();
            exit;
        }
        $stmt->bind_param("ssiis", $id, $name, $due_date, $notify_day, $emails);
        $message = "Bill added successfully!";
    }

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(["success" => true, "message" => $message]);
    } else {
        error_log("Execute failed: " . $stmt->error);
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Query execution failed: " . $stmt->error]);
    }

    $stmt->close();
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
}

$conn->close();
ob_end_flush();
?>