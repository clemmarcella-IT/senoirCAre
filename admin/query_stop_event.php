<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
mysqli_query($conn, "UPDATE events SET EventStatus = 'Stopped' WHERE EventID = '$id'");
header("location:event_attendance.php?id=$id");
?>