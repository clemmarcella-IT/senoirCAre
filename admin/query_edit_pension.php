<?php
include("../includes/db_connection.php");

// Get the OLD values from the URL so we know which record to find
$old_reason = $_GET['old_reason'];
$old_date = $_GET['old_date'];

// Get the NEW values from the Form
$new_reason = $_POST['pname'];
$new_date = $_POST['pdate'];
$new_amount = $_POST['pamount'];

// Perform the update
mysqli_query($conn, "UPDATE pension SET 
    PensionReason = '$new_reason', 
    PensionDate = '$new_date', 
    PensionCashAmount = '$new_amount' 
    WHERE PensionReason = '$old_reason' AND PensionDate = '$old_date'");
?>

<!-- Alert and Redirect -->
<script>
    window.alert('Pension Payout updated successfully!');
    window.location="pension.php";
</script>