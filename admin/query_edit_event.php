<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
$ename = $_POST['ename'];
$edate = $_POST['edate'];
$etime = $_POST['etime'];

mysqli_query($conn, "UPDATE event_master SET EventName='$ename', EventDate='$edate', EventTime='$etime' WHERE EventID='$id' AND EventType='Activity'");
?>
<script>
    window.alert('Event Activity updated successfully!');
    window.location="events.php";
</script>