<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM events WHERE EventID='$id'");
header("location:events.php");
?>