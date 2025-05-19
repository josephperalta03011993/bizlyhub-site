<?php
ob_start(); // Start output buffering
ini_set('display_errors', 0); // Disable display errors to prevent output
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once 'conn.php'; // Include database connection

// Get input data
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    error_log("Invalid JSON input: " . file_get_contents('php://input'));
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid JSON input"]);
    ob_end_flush();
    exit;
}

$id = isset($input['id']) ? htmlspecialchars($input['id'], ENT_QUOTES, 'UTF-8') : '';
if (!$id) {
    error_log("Invalid or missing ID");
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid or missing ID"]);
    ob_end_flush();
    exit;
}

try {
    $stmt = $conn->prepare("DELETE FROM bills WHERE id = ?");
    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error);
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Query preparation failed: " . $conn->error]);
        ob_end_flush();
        exit;
    }
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            http_response_code(200);
            echo json_encode(["success" => true, "message" => "Bill deleted successfully!"]);
        } else {
            error_log("Bill not found: id=$id");
            http_response_code(404);
            echo json_encode(["success" => false, "message" => "Bill not found"]);
        }
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
ob_end_flush(); // Send output
?>