<?php require_once('includes/session.php'); 

// Handle QR Scan AJAX Request (Duplication Constraint)
if(isset($_POST['scanned_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['scanned_id']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $date = date('Y-m-d');
    $time = date('H:i:s');

    // 1. Check if ID exists
    $checkUser = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo='$id'");
    if(mysqli_num_rows($checkUser) == 0) {
        echo "<script>alert('Error: Unregistered QR Code.'); window.location='health.php';</script>";
        exit;
    }

    // 2. DUPLICATION CONSTRAINT CHECK (Cannot scan twice for health on the same day)
    $checkDup = mysqli_query($conn, "SELECT * FROM healthrecords WHERE OscaIDNo='$id' AND HealthDate='$date'");
    if(mysqli_num_rows($checkDup) > 0) {
        echo "<script>alert('Duplicate: This Senior has already been recorded for Health today.'); window.location='health.php';</script>";
    } else {
        // 3. Insert Record
        mysqli_query($conn, "INSERT INTO healthrecords (OscaIDNo, HealthDate, HealthPurpose, HealthAttendanceStatus, HealthTimeIn) 
                             VALUES ('$id', '$date', '$purpose', 'present', '$time')");
        echo "<script>alert('Success: Health Record Added for $id.'); window.location='health.php';</script>";
    }
    exit;
}

// Delete Logic
if(isset($_GET['delete'])) {
    mysqli_query($conn, "DELETE FROM healthrecords WHERE HealthRecordID='".$_GET['delete']."'");
    header("Location: health.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Health Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode"></script> <!-- QR Scanner Library -->
</head>
<body class="d-flex">
    <?php include('includes/sidebar.php'); ?>

    <div class="flex-grow-1 p-4 bg-light">
        <h2>Health Check-up & Medication Records</h2>
        
        <div class="card mt-4 mb-4">
            <div class="card-header bg-success text-white fw-bold">Take Attendance via QR</div>
            <div class="card-body row">
                <!-- Camera Window -->
                <div class="col-md-6 text-center">
                    <div id="reader" style="width: 100%; max-width: 400px; margin: 0 auto;"></div>
                </div>
                <!-- Manual Data Form -->
                <div class="col-md-6">
                    <form method="POST" id="qrForm">
                        <div class="mb-3">
                            <label>Scanned OscaIDNo</label>
                            <input type="text" name="scanned_id" id="scanned_id" class="form-control" readonly required>
                        </div>
                        <div class="mb-3">
                            <label>Health Purpose</label>
                            <select name="purpose" class="form-select" required>
                                <option value="Routine Check-up">Routine Check-up</option>
                                <option value="X-Ray">X-Ray</option>
                                <option value="Maintenance Capsule Issuance">Maintenance Capsule Issuance</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>Record Attendance (Present)</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead><tr><th>Record ID</th><th>OscaIDNo</th><th>Date</th><th>Time</th><th>Purpose</th><th>Status</th><th>Action</th></tr></thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM healthrecords ORDER BY HealthDate DESC");
                        while($row = mysqli_fetch_assoc($q)): ?>
                        <tr>
                            <td><?php echo $row['HealthRecordID']; ?></td>
                            <td><span class="badge bg-primary"><?php echo $row['OscaIDNo']; ?></span></td>
                            <td><?php echo $row['HealthDate']; ?></td>
                            <td><?php echo $row['HealthTimeIn']; ?></td>
                            <td><?php echo $row['HealthPurpose']; ?></td>
                            <td><span class="text-success fw-bold"><?php echo $row['HealthAttendanceStatus']; ?></span></td>
                            <td><a href="health.php?delete=<?php echo $row['HealthRecordID']; ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- QR Scanner Logic -->
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Put the scanned text into the input box
            document.getElementById('scanned_id').value = decodedText;
            document.getElementById('submitBtn').disabled = false; // Enable submit button
            
            // Optional: Auto-submit form when scanned
            // document.getElementById('qrForm').submit(); 
        }

        var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>