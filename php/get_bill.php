<?php
ob_start();
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once 'conn.php';

$id = isset($_GET['id']) ? htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8') : '';
if (!$id) {
    error_log("Invalid or missing ID");
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid or missing ID"]);
    ob_end_flush();
    exit;
}

try {
    $stmt = $conn->prepare("SELECT id, name, due_date, notify_day, emails, notifications FROM bills WHERE id = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
        ob_end_flush();
        exit;
    }
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        http_response_code(200);
        echo json_encode($row);
    } else {
        error_log("Bill not found: id=$id");
        http_response_code(404);
        echo json_encode(["success" => false, "message" => "Bill not found"]);
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