<?php
include("../includes/db_connection.php");

$id = $_POST['oscaID']; 
$hname = $_POST['hname']; 
$hdate = $_POST['hdate']; 
$hpurpose = $_POST['hpurpose'];
$time = date('H:i:s');

// Use mysqli_fetch_array to check for duplicate
$check = mysqli_query($conn, "SELECT * FROM healthrecords WHERE OscaIDNo='$id' AND HealthName='$hname' AND HealthDate='$hdate'");
$row = mysqli_fetch_array($check);

if($row) {
    echo "<script>alert('Duplicate: Already marked as present.'); window.history.back();</script>";
} else {
    mysqli_query($conn, "INSERT INTO healthrecords (OscaIDNo, HealthName, HealthDate, HealthPurpose, HealthAttendanceStatus, HealthTimeIn, HealthEventStatus) 
    VALUES ('$id', '$hname', '$hdate', '$hpurpose', 'present', '$time', 'Active')");
    
    header("location:health_attendance.php?name=$hname&date=$hdate");
}
?>