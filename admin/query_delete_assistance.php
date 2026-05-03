<?php
include("../includes/db_connection.php");
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM event_master WHERE EventID='$id' AND EventType='Assistance'");
header("location:assistance.php");
?>