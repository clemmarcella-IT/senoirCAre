<?php
include("../includes/db_connection.php");

$old_name = $_GET['old_name'];
$old_date = $_GET['old_date'];

$new_name = $_POST['hname'];
$new_date = $_POST['hdate'];
$new_purpose = $_POST['hpurpose'];

mysqli_query($conn, "UPDATE healthrecords SET 
    HealthName = '$new_name', 
    HealthDate = '$new_date', 
    HealthPurpose = '$new_purpose' 
    WHERE HealthName = '$old_name' AND HealthDate = '$old_date'");
?>
<script>
    window.alert('Health Event updated successfully!');
    window.location="health.php";
</script>