<?php
include("../includes/db_connection.php");
$id = $_POST['oscaID']; 
$aname = $_POST['aname']; 
$adate = $_POST['adate']; 
$atype = $_POST['atype'];
$time = date('H:i:s');

// We use mysqli_fetch_array exactly as you wanted to check if they are duplicate
$check = mysqli_query($conn, "SELECT * FROM assistance WHERE OscaIDNo='$id' AND AssistanceName='$aname' AND AssistanceDate='$adate'");
$row = mysqli_fetch_array($check);

if($row) {
    echo "<script>alert('Duplicate: Already claimed.'); window.history.back();</script>";
} else {
    mysqli_query($conn, "INSERT INTO assistance (OscaIDNo, AssistanceName, TypeAssistance, AssistanceDate, AssistanceAttendanceStatus, AssistanceTimeIn, AssistanceEventStatus) 
    VALUES ('$id', '$aname', '$atype', '$adate', 'claimed', '$time', 'Active')");
    
    header("location:assistance_attendance.php?name=" . urlencode($aname) . "&date=" . $adate);
}
?>