<?php
include("../includes/db_connection.php");

$id = $_POST['oscaID'];
$preason = $_POST['preason']; // The Session/Payout Name
$pdate = $_POST['pdate'];

$new_control = $_POST['new_control'];
$new_reason = $_POST['new_reason'];

// 1. Update the Control No (for everyone)
// 2. Update the Reason (only if they provided one, otherwise clear it)
if (!empty($new_reason)) {
    // If an admin typed a reason, save it as the status
    $sql = "UPDATE pension SET 
            ControlNo = '$new_control', 
            PensionReason = '$new_reason' 
            WHERE OscaIDNo = '$id' AND PensionReason = '$preason' AND PensionDate = '$pdate'";
} else {
    // If the admin left it empty, clear the reason so they show as 'Unclaimed'
    $sql = "UPDATE pension SET 
            ControlNo = '$new_control', 
            PensionReason = '' 
            WHERE OscaIDNo = '$id' AND PensionReason = '$preason' AND PensionDate = '$pdate'";
}

mysqli_query($conn, $sql);

header("location:pension_attendance.php?reason=$preason&date=$pdate");
?>