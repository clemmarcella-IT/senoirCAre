<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
mysqli_query($conn, "UPDATE activities SET ActivityStatus = 'Stopped' WHERE ActivityID = '$id'");
header("location:activity_attendance.php?id=$id");
?>