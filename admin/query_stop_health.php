<?php
include("../includes/db_connection.php");

$id = $_GET['id'];

mysqli_query($conn, "UPDATE event_master SET EventStatus='Stopped' WHERE EventID='$id' AND EventType='Health'");

header("location:health_attendance.php?id=$id");
?>