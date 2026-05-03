<?php
include("../includes/db_connection.php");

$id = $_GET['id'];

$new_name = $_POST['aname'];
$new_date = $_POST['adate'];

mysqli_query($conn, "UPDATE event_master SET 
    EventName = '$new_name', 
    EventDate = '$new_date'
    WHERE EventID = '$id' AND EventType='Assistance'");
?>
<script>
    window.alert('Assistance Record updated successfully!');
    window.location="assistance.php";
</script>