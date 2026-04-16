<?php
include("../includes/db_connection.php");

$name = $_GET['name'];
$date = $_GET['date'];
$status = $_GET['status']; // "Stopped" or "Active"

// Update ALL rows belonging to this Assistance group to ensure everything stays synced
mysqli_query($conn, "UPDATE assistance SET AssistanceEventStatus='$status' WHERE AssistanceName='$name' AND AssistanceDate='$date'");

// Send them back to the scanner screen
header("location:assistance_attendance.php?name=$name&date=$date");
?>