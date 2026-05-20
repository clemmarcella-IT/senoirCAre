<?php
include("../includes/db_connection.php");

$id = $_POST['oscaID'];
$pid = $_POST['pid'];

// Validate pensioner status
$senior_q = mysqli_query($conn, "SELECT PensionerStatus FROM seniors WHERE OscaIDNo='$id'");
$senior = mysqli_fetch_array($senior_q);
if (!$senior || $senior['PensionerStatus'] !== 'Pensioner') {
    echo "<script>alert('Invalid pensioner or not registered as Pensioner.'); window.history.back();</script>";
    exit;
}

$amount_q = mysqli_query($conn, "SELECT CashAmount FROM pension_master WHERE PensionMasterID='$pid'");
$amount_row = mysqli_fetch_array($amount_q);
$amount = $amount_row ? $amount_row['CashAmount'] : 0;
$date = date('Y-m-d');
$time = date('H:i:s');

$check = mysqli_query($conn, "SELECT * FROM transaction_logs WHERE OscaIDNo='$id' AND PensionMasterID='$pid' AND ClaimType='Pension Claim'");
$row = mysqli_fetch_array($check);

if ($row) {
    if ($row['Status'] === 'Claimed') {
        echo "<script>alert('Duplicate: Already claimed.'); window.history.back();</script>";
        exit;
    } else {
        mysqli_query($conn, "UPDATE transaction_logs SET Status='Claimed', Amount_Released='$amount', DateRecorded='$date', TimeRecorded='$time', IsRead=0 WHERE OscaIDNo='$id' AND PensionMasterID='$pid' AND ClaimType='Pension Claim'");
    }
} else {
    mysqli_query($conn, "INSERT INTO transaction_logs (OscaIDNo, PensionMasterID, ClaimType, Amount_Released, DateRecorded, TimeRecorded, Status) 
        VALUES ('$id', '$pid', 'Pension Claim', '$amount', '$date', '$time', 'Claimed')");
}

header("location:pension_attendance.php?id=$pid");
?>