<?php
	include("../includes/db_connection.php");

	// 1. Get the ID of the senior we are editing from the URL
	$id = $_GET['id'];
	
	// 2. Collect all the text information from the form
	$newOscaID  = mysqli_real_escape_string($conn, trim($_POST['oscaid']));
	$fname      = mysqli_real_escape_string($conn, trim($_POST['fname']));
	$mi         = mysqli_real_escape_string($conn, trim($_POST['mi']));
	$lname      = mysqli_real_escape_string($conn, trim($_POST['lname']));
	$sex        = mysqli_real_escape_string($conn, trim($_POST['sex']));
	$bday       = mysqli_real_escape_string($conn, trim($_POST['bday']));
	$purok      = mysqli_real_escape_string($conn, trim($_POST['purok']));
	$status     = mysqli_real_escape_string($conn, trim($_POST['status']));
    $pensionStatus = mysqli_real_escape_string($conn, trim($_POST['pension_status']));

    if (!$newOscaID || !$fname || !$lname) {
        echo "<script>alert('OSCA ID, First Name, and Last Name are required.'); window.history.back();</script>";
        exit;
    }

    if ($newOscaID !== $id) {
        $exists = mysqli_query($conn, "SELECT OscaIDNo FROM seniors WHERE OscaIDNo = '$newOscaID'");
        if (mysqli_num_rows($exists) > 0) {
            echo "<script>alert('OSCA ID already exists. Please choose a different ID.'); window.history.back();</script>";
            exit;
        }
    }

    // 3. Build and run the SQL command
    if ($newOscaID !== $id) {
        // If the OSCA ID changed, update related FK tables first by inserting a new senior record and moving child rows.
        $insertNew = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, Purok, Barangay, Birthday, CitizenStatus, PensionerStatus)
                      VALUES ('$newOscaID', '$lname', '$fname', '$mi', '$sex', '$purok', (SELECT Barangay FROM seniors WHERE OscaIDNo = '$id'), '$bday', '$status', '$pensionStatus')";
        mysqli_query($conn, $insertNew);

        mysqli_query($conn, "UPDATE transaction_logs SET OscaIDNo = '$newOscaID' WHERE OscaIDNo = '$id'");
        mysqli_query($conn, "UPDATE dues_payments SET OscaIDNo = '$newOscaID' WHERE OscaIDNo = '$id'");
        mysqli_query($conn, "DELETE FROM seniors WHERE OscaIDNo = '$id'");
    } else {
        mysqli_query($conn, "UPDATE seniors SET 
            FirstName = '$fname', 
            MiddleName = '$mi', 
            LastName = '$lname', 
            Sex = '$sex', 
            Birthday = '$bday', 
            Purok = '$purok', 
            CitizenStatus = '$status', 
            PensionerStatus = '$pensionStatus' WHERE OscaIDNo = '$id'");
    }
	
	// 5. Show a simple alert and go back to the list
	?>
		<script>
			window.alert('Senior Citizen Profile updated successfully!');
			window.location="profiling.php";
		</script>
	<?php
?>