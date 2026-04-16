<?php
include("../includes/db_connection.php");

// Get the session identifiers from the form
$reason = $_POST['preason'];
$pdate = $_POST['pdate'];

// Update the session status to 'Stopped'
mysqli_query($conn, "UPDATE pension SET PensionEventStatus='Stopped' WHERE PensionReason='$reason' AND PensionDate='$pdate'");

// Redirect back to the attendance view
header("location:pension_attendance.php?reason=$reason&date=$pdate");
?> 