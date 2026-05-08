<?php
include("../includes/db_connection.php");

// Check if the 'id' parameter is present in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get the updated values from the Edit Modal form
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];

    $month = date("F", strtotime($due_date));
    $year = date("Y", strtotime($due_date));
    $contribution_name = "MonthlyDue_{$month}_{$year}";

    // Update the record in the monthly_dues_master table
    $update_query = "UPDATE monthly_dues_master 
                     SET Contribution_Name = '$contribution_name', 
                         Amount_Required = '$amount', 
                         Due_Date = '$due_date' 
                     WHERE DuesID = '$id'";

    if(mysqli_query($conn, $update_query)) {
        echo "<script>
                alert('Monthly Dues successfully updated!');
                window.location='monthly_dues.php';
              </script>";
    } else {
        echo "<script>
                alert('Error updating the record.');
                window.location='monthly_dues.php';
              </script>";
    }
} else {
    // Redirect back to the dues page if accessed directly without an ID
    header("location:monthly_dues.php");
    exit();
}
?>