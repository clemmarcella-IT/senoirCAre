<?php
include("../includes/db_connection.php");

// Get the identifiers from the URL
$reason = $_GET['reason'];
$date = $_GET['date'];

// Perform the deletion
mysqli_query($conn, "DELETE FROM pension WHERE PensionReason='$reason' AND PensionDate='$date'");
?>

<!-- Alert and Redirect -->
<script>
    window.alert('Pension Payout deleted successfully!');
    window.location="pension.php";
</script>