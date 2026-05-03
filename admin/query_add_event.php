<?php
include("../includes/db_connection.php");
$name = $_POST['ename']; 
$date = $_POST['edate']; 
$time = $_POST['etime'];

mysqli_query($conn, "INSERT INTO event_master (EventName, EventDate, EventTime, EventType, EventStatus) 
VALUES ('$name', '$date', '$time', 'Activity', 'Active')");
?>
<script>
    window.alert('Event Activity added successfully!');
    window.location="events.php";
</script>