<?php
include("../includes/db_connection.php");
$name = $_POST['hname']; 
$date = $_POST['hdate']; 
$purpose = $_POST['hpurpose'];

mysqli_query($conn, "INSERT INTO event_master (EventName, EventDate, EventType, EventStatus) 
VALUES ('$name', '$date', 'Health', 'Active')");

$event_id = mysqli_insert_id($conn);

mysqli_query($conn, "INSERT INTO health_details (EventID, HealthPurpose) 
VALUES ('$event_id', '$purpose')");
?>
<script>
    window.alert('Health Event added successfully!');
    window.location="health.php";
</script>