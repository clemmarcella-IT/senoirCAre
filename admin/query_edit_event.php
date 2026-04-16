<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
$name = $_POST['ename']; $date = $_POST['edate']; $time = $_POST['etime'];

mysqli_query($conn, "UPDATE events SET EventName='$name', eventDate='$date', EventTime='$time' WHERE EventID='$id'");

header("location:events.php");
?>