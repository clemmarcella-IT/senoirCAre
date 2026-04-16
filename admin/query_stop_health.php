<?php
include("../includes/db_connection.php");

$name = $_GET['name'];
$date = $_GET['date'];

mysqli_query($conn, "UPDATE healthrecords SET HealthEventStatus='Stopped' WHERE HealthName='$name' AND HealthDate='$date'");
header("location:health_attendance.php?name=$name&date=$date");
?>