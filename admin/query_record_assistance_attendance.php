<?php
include("../includes/db_connection.php");
$id = $_POST['oscaID'];
$eid = $_POST['eid'];
$time = date('H:i:s');

// We use mysqli_fetch_array exactly as you wanted to check if they are duplicate
$check = mysqli_query($conn, "SELECT * FROM event_attendance WHERE OscaIDNo='$id' AND EventID='$eid'");
$row = mysqli_fetch_array($check);

if($row) {
    echo "<script>alert('Duplicate: Already claimed.'); window.history.back();</script>";
} else {
    mysqli_query($conn, "INSERT INTO event_attendance (EventID, OscaIDNo, TimeIn, Status) 
    VALUES ('$eid', '$id', '$time', 'Claimed')");
    
    header("location:assistance_attendance.php?id=$eid");
}
?>