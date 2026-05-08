<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM activities WHERE ActivityID='$id'");
header("location:activity.php");
?>