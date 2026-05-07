<?php
include("includes/session.php");

if(isset($_POST['ename'])){
    $name = $_POST['ename']; 
    $date = $_POST['edate']; 
    $time = $_POST['etime'];
    $type = $_POST['etype']; // 'Meeting', 'Pension', or 'Benefit Distribution'

    mysqli_query($conn, "INSERT INTO event_master (EventName, EventDate, EventTime, EventType, EventStatus) 
    VALUES ('$name', '$date', '$time', '$type', 'Active')");

    $redirect = ($type == 'Meeting') ? 'activity.php' : (($type == 'Pension') ? 'pension.php' : 'benefits.php');
    echo "<script>alert('Activity scheduled successfully!'); window.location='$redirect';</script>";
}
?>