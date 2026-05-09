<?php
include("../includes/db_connection.php");

// Check if the 'id' parameter is present in the URL
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the Monthly Dues from the master table
    // Note: Because of your database's 'ON DELETE CASCADE' constraint, 
    // all payments/attendance connected to this DuesID will be automatically deleted as well.
    $delete_query = mysqli_query($conn, "DELETE FROM monthly_dues_master WHERE DuesID='$id'");

    if($delete_query) {
        echo "<script>
                alert('Monthly Dues and all its payment records have been deleted successfully!');
                window.location='monthly_dues.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting record.');
                window.location='monthly_dues.php';
              </script>";
    }
} else {
    // Redirect back if accessed without an ID
    header("location:monthly_dues.php");
    exit();
}
?>