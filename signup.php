<?php
// Start or resume session
session_start();

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

// Process registration form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize user input
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    // Validate input
    if (empty($username) || empty($password)) {
        echo "Username and password are required!";
        exit();
    }
    
    // Check if username already exists
    $checkStmt = $conn->prepare("SELECT user_id FROM users WHERE username = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        echo "Username already exists!";
        $checkStmt->close();
        exit();
    }
    $checkStmt->close();
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare SQL statement to insert new user
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashedPassword);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to login page
        header("Location: admin.php?message=Registration successful! Please login.");
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
} else {
    // Display registration form
    // Form HTML would go here
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Sign Up</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/login.css">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
</head>
<body>
    <div class="login-container animate-in">
        <h2 class="section-title">Create an Account</h2>
        <form action="signup.php" method="POST" class="login-form" aria-label="Signup form">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder=" " required aria-required="true">
                <label for="username">Username</label>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder=" " required aria-required="true">
                <label for="password">Password</label>
            </div>
            <button type="submit" class="submit-button">Sign Up</button>
            <?php
                if (isset($_GET['error'])) {
                    echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                if (isset($_GET['message'])) {
                    echo '<p class="success-message">' . htmlspecialchars($_GET['message']) . '</p>';
                }
            ?>
            <p class="signup-link">Already have an account? <a href="admin.php">Login</a></p>
        </form>
    </div>
</body>
</html>