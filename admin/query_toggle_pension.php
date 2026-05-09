<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
$status = $_GET['status']; // Active or Stopped

mysqli_query($conn, "UPDATE event_master SET EventStatus='$status' WHERE EventID='$id' AND EventType='Pension'");
header("location:pension_attendance.php?id=$id");
?>