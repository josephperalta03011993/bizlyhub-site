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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BizlyHub - Dashboard</title>
    <link rel="icon" type="image/png" href="favicon.ico">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" as="style" onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/dashboard.css">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet"></noscript>
</head>
<body>
    <header class="dashboard-header">
        <div class="logo">BizlyHub</div>
        <div class="user-info">
            Welcome, <?php echo htmlspecialchars($username); ?> (<?php echo htmlspecialchars($role); ?>)
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </header>
    
    <main class="dashboard-content">
        <h1>Welcome to BizlyHub Dashboard</h1>
        <p>You are now logged in to your account.</p>
        
        <div class="dashboard-widgets">
            <!-- Dashboard content would go here -->
            <div class="widget">
                <h3>Quick Stats</h3>
                <p>This is a placeholder for dashboard content.</p>
            </div>
        </div>
    </main>
    
    <footer class="dashboard-footer">
        <p>&copy; 2025 BizlyHub. All rights reserved.</p>
    </footer>
</body>
</html>