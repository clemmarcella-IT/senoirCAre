<?php
// Start the session so we can destroy it
session_start();

// Clear all session variables
session_unset();

// Destroy the session completely
session_destroy();

// Redirect back to the ADMIN login page
header("Location: login.php");
exit();
?>