<?php
// Start or resume session
session_start();


// Database connection parameters
// $dbHost = "localhost";
// $dbUser = "u414060592_landing";
// $dbPass = '8d$Z[1Dm';
// $dbName = "u414060592_landing";

// Database connection parameters
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "bizlyhub";

// Create database connection
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user input
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // Don't escape password before verification
    
    // Validate input
    if (empty($username) || empty($password)) {
        header("Location: admin.php?error=Username and password are required");
        exit();
    }
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Verify password (using password_verify for hashed passwords)
        if (password_verify($password, $user['password'])) {
            // Password is correct, create session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            
            // Update last login timestamp
            $update_stmt = $conn->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE user_id = ?");
            $update_stmt->bind_param("i", $user['user_id']);
            $update_stmt->execute();
            $update_stmt->close();
            
            // Redirect to dashboard or home page
            header("Location: dashboard.php");
            exit();
        } else {
            // Password is incorrect
            header("Location: admin.php?error=Invalid username or password");
            exit();
        }
    } else {
        // Username not found
        header("Location: admin.php?error=Invalid username or password");
        exit();
    }
    
    $stmt->close();
} else {
    // If someone tries to access this page directly without submitting the form
    header("Location: admin.php");
    exit();
}

$conn->close();
?>