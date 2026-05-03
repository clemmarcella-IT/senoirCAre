<?php
include("../includes/db_connection.php");

$id = $_GET['id'];

$new_name = $_POST['hname'];
$new_date = $_POST['hdate'];
$new_purpose = $_POST['hpurpose'];

mysqli_query($conn, "UPDATE event_master SET 
    EventName = '$new_name', 
    EventDate = '$new_date'
    WHERE EventID='$id'");

mysqli_query($conn, "UPDATE health_details SET 
    HealthPurpose = '$new_purpose' 
    WHERE EventID='$eid'");
?>
<script>
    window.alert('Health Event updated successfully!');
    window.location="health.php";
</script>