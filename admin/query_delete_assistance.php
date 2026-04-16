<?php
include("../includes/db_connection.php");
$name = $_GET['name'];
$date = $_GET['date'];

mysqli_query($conn, "DELETE FROM assistance WHERE AssistanceName='$name' AND AssistanceDate='$date'");
header("location:assistance.php");
?>