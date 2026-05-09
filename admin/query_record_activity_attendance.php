<?php
include("includes/session.php");

$id = isset($_POST['oscaID']) ? $_POST['oscaID'] : '';
$aid = isset($_POST['activity_id']) ? $_POST['activity_id'] : '';
$date = date('Y-m-d');
$time = date('H:i:s');

if ($id == '' || $aid == '') {
    echo "<script>alert('Invalid scan result. Please scan the senior QR code again.'); window.history.back();</script>";
    exit;
}

$seniorCheck = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo='$id'");
$seniorRow = mysqli_fetch_array($seniorCheck);
if (!$seniorRow) {
    echo "<script>alert('Senior record not found. Please verify the scanned QR code.'); window.history.back();</script>";
    exit;
}

$check = mysqli_query($conn, "SELECT * FROM transaction_logs WHERE OscaIDNo='$id' AND ActivityID='$aid'");
if (mysqli_fetch_array($check)) {
    echo "<script>alert('Duplicate: Already marked present.'); window.history.back();</script>";
    exit;
}

mysqli_query($conn, "INSERT INTO transaction_logs (OscaIDNo, ActivityID, DateRecorded, TimeRecorded, Status) VALUES ('$id', '$aid', '$date', '$time', 'Present')");
header("location:activity_attendance.php?id=$aid");
?>