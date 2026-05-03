<?php
include("../includes/db_connection.php");
$name = $_POST['aname']; 
$date = $_POST['adate']; 
$type = $_POST['atype'];

mysqli_query($conn, "INSERT INTO event_master (EventName, EventDate, EventType, EventStatus) 
VALUES ('$name', '$date', 'Assistance', 'Active')");
?>
<script>
    window.alert('Assistance Record added successfully!');
    window.location="assistance.php";
</script>