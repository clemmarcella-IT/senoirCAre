<?php
include("includes/session.php");

if(isset($_POST['ename'])){
    $name = $_POST['ename']; 
    $date = $_POST['edate']; 
    $time = $_POST['etime'];
    $type = $_POST['etype']; // 'Meeting', 'Pension', or 'Benefit Distribution'

    mysqli_query($conn, "INSERT INTO activities (ActivityName, ActivityDate, ActivityTimeStart, ActivityStatus) 
    VALUES ('$name', '$date', '$time', 'Active')");

    header("location:activity.php");
}
?>