<?php
include("../includes/db_connection.php");

$date = $_POST['pdate'];
$amount = $_POST['pamount'];

// Insert into event_master
$name = 'Pension Payout - ' . $date;
$result = mysqli_query($conn, "INSERT INTO event_master (EventName, EventDate, EventType, EventStatus) 
VALUES ('$name', '$date', 'Pension', 'Active')");

if ($result) {
    // Get the EventID
    $event_id = mysqli_insert_id($conn);

    // Insert into pension_details
    mysqli_query($conn, "INSERT INTO pension_details (EventID, CashAmount) 
    VALUES ('$event_id', '$amount')");
} else {
    echo "<script>alert('Error adding pension event!'); window.location='pension.php';</script>";
    exit;
}
?>
<script>
    window.alert('Pension Payout Session created successfully!');
    window.location="pension.php";
</script>