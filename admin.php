<?php
// Start session to enable messages
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Login</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/login.css">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
</head>
<body>
    <div class="login-container animate-in">
        <h2 class="section-title">Login to Your Account</h2>
        <form action="login.php" method="POST" class="login-form" aria-label="Login form">
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder=" " required aria-required="true">
                <label for="username">Username</label>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder=" " required aria-required="true">
                <label for="password">Password</label>
            </div>
            <button type="submit" class="submit-button">Login</button>
            <?php
                if (isset($_GET['error'])) {
                    echo '<p class="error-message">' . htmlspecialchars($_GET['error']) . '</p>';
                }
                if (isset($_GET['message'])) {
                    echo '<p class="success-message">' . htmlspecialchars($_GET['message']) . '</p>';
                }
            ?>
            <p class="signup-link">Don't have an account? <a href="signup.php">Sign up</a></p>
        </form>
    </div>
</body>
</html>