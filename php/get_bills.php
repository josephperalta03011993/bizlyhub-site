<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once 'conn.php';

try {
    $stmt = $conn->prepare("SELECT id, name, due_date, notify_day, emails, notifications FROM bills");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
        ob_end_flush();
        exit;
    }
    $stmt->execute();
    $result = $stmt->get_result();

    $bills = [];
    while ($row = $result->fetch_assoc()) {
        $row['notifications'] = (bool)$row['notifications'];
        $bills[] = $row;
    }

    http_response_code(200);
    echo json_encode($bills);

    $stmt->close();
} catch (Exception $e) {
    error_log("Exception: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
}

$conn->close();
ob_end_flush();
?>