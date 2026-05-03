<?php
include("../includes/db_connection.php");

$id = $_GET['id'];

// Get the NEW values from the Form
$new_date = $_POST['pdate'];
$new_amount = $_POST['pamount'];

// Automatically create the Payout Name based on the Date selected
$new_name = 'Pension Payout - ' . $new_date;

// Update event_master table
mysqli_query($conn, "UPDATE event_master SET EventName='$new_name', EventDate='$new_date' WHERE EventID='$id'");

// Update pension_details table
mysqli_query($conn, "UPDATE pension_details SET CashAmount='$new_amount' WHERE EventID='$id'");
?>

<!-- Alert and Redirect -->
<script>
    window.alert('Pension Payout updated successfully!');
    window.location="pension.php";
</script>