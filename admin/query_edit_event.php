<?php
include("../includes/db_connection.php");
$id = $_GET['id'];
$ename = $_POST['ename'];
$edate = $_POST['edate'];
$etime = $_POST['etime'];

mysqli_query($conn, "UPDATE events SET EventName='$ename', eventDate='$edate', EventTime='$etime' WHERE EventID='$id'");
?>
<script>
    window.alert('Event Activity updated successfully!');
    window.location="events.php";
</script>