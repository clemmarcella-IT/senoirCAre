<?php
include("../includes/db_connection.php");


if(isset($_GET['id'])) {
    $id = $_GET['id'];


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
    header("location:monthly_dues.php");
    exit();
}
?>