<?php
session_start();

// Connects to your main database file
include_once(__DIR__ . '/../../includes/db_connection.php'); 

// Check if user ID is provided via GET parameter
if (!isset($_GET['id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

// Validate that the ID exists in the seniors table
$check_senior = mysqli_query($conn, "SELECT OscaIDNo FROM seniors WHERE OscaIDNo = '$id'");
$senior_record = mysqli_fetch_array($check_senior);

if (!$senior_record) {
    echo "<script>alert('Senior record not found.'); window.location='login.php';</script>";
    exit();
}
?>
