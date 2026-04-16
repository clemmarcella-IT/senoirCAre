<?php
include("../includes/db_connection.php");
$name = $_POST['ename']; 
$date = $_POST['edate']; 
$time = $_POST['etime'];
mysqli_query($conn, "INSERT INTO events (EventName, eventDate, EventTime, EventStatus) 
VALUES ('$name', '$date', '$time', 'Active')");
header("location:events.php");
?>