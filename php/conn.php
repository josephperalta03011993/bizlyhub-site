<?php 
// Start or resume session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php?error=Please login to access the dashboard");
    exit();
}

// Get user information from session
$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Database connection
// $servername = "localhost";
// $password = '8d$Z[1Dm';
// $dbname = "u414060592_landing";
// $username = "u414060592_landing";

$servername = "localhost";
$db_username = "root"; 
$password = ""; 
$dbname = "bizlyhub"; 

// Create connection
$conn = new mysqli($servername, $db_username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>