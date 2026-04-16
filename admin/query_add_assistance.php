<?php
include("../includes/db_connection.php");
$name = $_POST['aname']; 
$date = $_POST['adate']; 
$type = $_POST['atype'];

mysqli_query($conn, "INSERT INTO assistance (OscaIDNo, AssistanceName, TypeAssistance, AssistanceDate, AssistanceEventStatus) 
VALUES (NULL, '$name', '$type', '$date', 'Active')");

header("location:assistance.php");
?>