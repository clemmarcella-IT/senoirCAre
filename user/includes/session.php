<?php
session_start();

// Connects to your main database file
include_once("../../includes/db_connection.php"); 

// Check if user ID is provided via GET parameter
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: login.php");
    exit();
}

// Validate that the ID exists in the seniors table
$id = mysqli_real_escape_string($conn, $_GET['id']);
$check_senior = mysqli_query($conn, "SELECT OscaIDNo FROM seniors WHERE OscaIDNo = '$id'");
if (!mysqli_fetch_array($check_senior)) {
    echo "<script>alert('Senior record not found.'); window.location='login.php';</script>";
    exit();
}
?>
