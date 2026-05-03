<?php
include("../includes/db_connection.php");
$name = $_POST['aname']; 
$date = $_POST['adate']; 
$type = $_POST['atype'];

// Insert into event_master
$result = mysqli_query($conn, "INSERT INTO event_master (EventName, EventDate, EventType, EventStatus) 
VALUES ('$name', '$date', 'Assistance', 'Active')");

if ($result) {
    $eventID = mysqli_insert_id($conn);
    
    // Insert into assistance_details
    mysqli_query($conn, "INSERT INTO assistance_details (EventID, AssistanceType) 
    VALUES ('$eventID', '$type')");
} else {
    echo "<script>alert('Error adding assistance event!'); 
    window.location='assistance.php';</script>";
    exit;
}
?>
<script>
    window.alert('Assistance Record added successfully!');
    window.location="assistance.php";
</script>