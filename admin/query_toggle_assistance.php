<?php
include("../includes/db_connection.php");

$id = $_GET['id'];
$status = $_GET['status']; // "Stopped" or "Active"

mysqli_query($conn, "UPDATE event_master SET EventStatus='$status' WHERE EventID='$id' AND EventType='Assistance'");

// Send them back to the scanner screen
header("location:assistance_attendance.php?id=$id");
?>