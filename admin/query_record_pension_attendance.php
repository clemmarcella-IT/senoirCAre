<?php
include("../includes/db_connection.php");
$id = $_POST['oscaID']; 
$reason = $_POST['preason']; 
$pdate = $_POST['pdate'];
$amount = $_POST['pamount'];
$time = date('H:i:s');

$check = mysqli_query($conn, "SELECT * FROM pension WHERE OscaIDNo='$id' AND PensionReason='$reason' AND PensionDate='$pdate'");
$row = mysqli_fetch_array($check);

if($row) {
    echo "<script>alert('Duplicate: Already claimed.'); window.history.back();</script>";
} else {
    mysqli_query($conn, "INSERT INTO pension (OscaIDNo, PensionReason, PensionDate, PensionCashAmount, PensionAttendanceStatus, pensionTimeRecieve, PensionEventStatus) 
    VALUES ('$id', '$reason', '$pdate', '$amount', 'Claimed', '$time', 'Active')");
    header("location:pension_attendance.php?reason=$reason&date=$pdate");
}
?>