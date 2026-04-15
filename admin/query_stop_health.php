<?php
include("../includes/db_connection.php");

// Get the name and date from the button click
$name = $_GET['name'];
$date = $_GET['date'];

// Change 'Active' to 'Stopped' for this specific event
mysqli_query($conn, "UPDATE healthrecords SET HealthEventStatus = 'Stopped' 
                    WHERE HealthName = '$name' AND HealthDate = '$date'");

// Go back to the page
header("location:health_attendance.php?name=$name&date=$date");
?>