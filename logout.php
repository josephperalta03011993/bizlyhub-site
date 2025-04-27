<?php
// Start or resume session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("Location: admin.php?message=You have been logged out successfully");
exit();
?>