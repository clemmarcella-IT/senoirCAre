<?php
include("../includes/db_connection.php");
$reason = $_GET['reason'];
$pdate = $_GET['date'];
$status = $_GET['status']; // Active or Stopped

mysqli_query($conn, "UPDATE pension SET PensionEventStatus='$status' WHERE PensionReason='$reason' AND PensionDate='$pdate'");
header("location:pension_attendance.php?reason=$reason&date=$pdate");
?>