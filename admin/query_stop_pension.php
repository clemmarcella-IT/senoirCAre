<?php
include("../includes/db_connection.php");

// Get the session identifier from the form
$id = $_POST['id'];

// Update the session status to 'Stopped'
mysqli_query($conn, "UPDATE event_master SET EventStatus='Stopped' WHERE EventID='$id' AND EventType='Pension'");

// Redirect back to the attendance view
header("location:pension_attendance.php?id=$id");
?> 