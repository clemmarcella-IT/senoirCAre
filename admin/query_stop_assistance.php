<?php
include("../includes/db_connection.php");
$name = $_GET['name'];
$date = $_GET['date'];

mysqli_query($conn, "UPDATE assistance SET AssistanceEventStatus='Stopped' WHERE AssistanceName='$name' AND AssistanceDate='$date'");
header("location:assistance_attendance.php?name=" . urlencode($name) . "&date=" . $date);
?>