<?php
include("../includes/db_connection.php");

// Get the identifier from the URL
$id = $_GET['id'];

// Perform the deletion
mysqli_query($conn, "DELETE FROM event_master WHERE EventID='$id' AND EventType='Pension'");
?>

<!-- Alert and Redirect -->
<script>
    window.alert('Pension Payout deleted successfully!');
    window.location="pension.php";
</script>