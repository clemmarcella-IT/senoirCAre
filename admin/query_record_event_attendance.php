<?php
include("includes/session.php");
$id  = $_POST['oscaID'];
$eid = $_POST['event_id'];
$date = date('Y-m-d');
$time = date('H:i:s');

// Check duplicate
$check = mysqli_query($conn, "SELECT * FROM transaction_records WHERE OscaIDNo='$id' AND EventID='$eid' AND Transaction_Type='Attendance'");
if(mysqli_fetch_array($check)) {
    echo "<script>alert('Duplicate: Already marked present.'); window.history.back();</script>";
} else {
    mysqli_query($conn, "INSERT INTO transaction_records (OscaIDNo, EventID, Transaction_Type, Date_Recorded, Time_Recorded, Status) 
                         VALUES ('$id', '$eid', 'Attendance', '$date', '$time', 'Present')");
    header("location:event_attendance.php?id=$eid");
}
?>