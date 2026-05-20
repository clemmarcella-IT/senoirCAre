<?php
include("../includes/db_connection.php");


if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    
    $amount = $_POST['amount'];
    $due_date = $_POST['due_date'];

    $month = date("F", strtotime($due_date));
    $year = date("Y", strtotime($due_date));
    $contribution_name = "MonthlyDue_{$month}_{$year}";

    
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
   
    header("location:monthly_dues.php");
    exit();
}
?>