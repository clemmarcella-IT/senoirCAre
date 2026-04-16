<?php
include("../includes/db_connection.php");

$name = $_GET['name'];
$date = $_GET['date'];

mysqli_query($conn, "DELETE FROM healthrecords WHERE HealthName='$name' AND HealthDate='$date'");
header("location:health.php");
?>