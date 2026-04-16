<?php
include("../includes/db_connection.php");

$name = $_POST['hname']; 
$date = $_POST['hdate']; 
$purpose = $_POST['hpurpose'];

// Creates the "Header" row
mysqli_query($conn, "INSERT INTO healthrecords (OscaIDNo, HealthName, HealthDate, HealthPurpose, HealthEventStatus) 
VALUES (NULL, '$name', '$date', '$purpose', 'Active')");

header("location:health.php");
?>