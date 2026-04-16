<?php
include("../includes/db_connection.php");
$id = $_POST['oscaID']; $eid = $_POST['event_id']; $time = date('H:i:s');

// Constraint check for duplicate
$check = mysqli_query($conn, "SELECT * FROM attendance WHERE OscaIDNo='$id' AND EventID='$eid'");
if(mysqli_num_rows($check) > 0) {
    echo "<script>alert('Duplicate: Already marked present.'); window.history.back();</script>";
} else {
    mysqli_query($conn, "INSERT INTO attendance (OscaIDNo, EventID, EventAttendanceStatus, attendanceTimeIn) VALUES ('$id', '$eid', 'present', '$time')");
    header("location:event_attendance.php?id=$eid");
}
?>