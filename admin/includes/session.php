<?php
session_start();

// Connects to your main database file
include("../includes/db_connection.php"); 

// If the admin is NOT logged in, kick them back to login.php
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>