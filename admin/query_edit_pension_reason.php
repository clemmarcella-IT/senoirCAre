<?php
include("../includes/db_connection.php");

$id = $_POST['oscaID'];
$preason = $_POST['preason']; // The Session/Payout Name
$pdate = $_POST['pdate'];

$new_control = $_POST['new_control'];
$new_reason = $_POST['new_reason'];

// We store the reason inside "PensionAttendanceStatus" instead of overwriting the Session Name (PensionReason)
if ($new_reason != "") {
    $status = $new_reason;
} else {
    $status = 'Unclaimed';
}

// 1. Check if the senior already has a record for this event
$check_sql = "SELECT * FROM pension WHERE OscaIDNo = '$id' AND PensionReason = '$preason' AND PensionDate = '$pdate'";
$check_res = mysqli_query($conn, $check_sql);
$row = mysqli_fetch_array($check_res);

if ($row) {
    // Check if they already claimed. Prevent un-claiming them if admin only typed a control number
    if ($row['PensionAttendanceStatus'] == 'Claimed' || $row['PensionAttendanceStatus'] == 'claimed') {
        if ($new_reason != "") {
            $final_status = $new_reason; 
        } else {
            $final_status = 'Claimed'; 
        }
    } else {
        $final_status = $status; 
    }

    // UPDATE RECORD
    $update_sql = "UPDATE pension SET ControlNo = '$new_control', PensionAttendanceStatus = '$final_status' WHERE OscaIDNo = '$id' AND PensionReason = '$preason' AND PensionDate = '$pdate'";
    mysqli_query($conn, $update_sql);

} else {
    // 2. If no record yet, grab the event's generic Cash Amount to prepare for an INSERT
    $amount_sql = "SELECT PensionCashAmount FROM pension WHERE PensionReason = '$preason' AND PensionDate = '$pdate' AND OscaIDNo IS NULL";
    $amount_res = mysqli_query($conn, $amount_sql);
    $amount_row = mysqli_fetch_array($amount_res);
    
    $amount = 0;
    if ($amount_row) {
        $amount = $amount_row['PensionCashAmount'];
    }

    // INSERT NEW RECORD because they are completely "Unclaimed" with no DB trace
    $insert_sql = "INSERT INTO pension (OscaIDNo, PensionReason, PensionDate, PensionCashAmount, ControlNo, PensionAttendanceStatus) VALUES ('$id', '$preason', '$pdate', '$amount', '$new_control', '$status')";
    mysqli_query($conn, $insert_sql);
}

header("location:pension_attendance.php?reason=$preason&date=$pdate");
?>