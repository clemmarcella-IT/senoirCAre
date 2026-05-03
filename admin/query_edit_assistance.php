<?php
include("../includes/db_connection.php");

$id = $_GET['id'];

$new_name = $_POST['aname'];
$new_date = $_POST['adate'];
$new_type = $_POST['atype'];

mysqli_query($conn, "UPDATE event_master SET 
    EventName = '$new_name', 
    EventDate = '$new_date'
    WHERE EventID = '$id' AND EventType='Assistance'");

// Update assistance_details or insert if missing
mysqli_query($conn, "INSERT INTO assistance_details (EventID, AssistanceType) 
    VALUES ('$id', '$new_type') 
    ON DUPLICATE KEY UPDATE AssistanceType = '$new_type'");
?>
<script>
    window.alert('Assistance Record updated successfully!');
    window.location="assistance.php";
</script>