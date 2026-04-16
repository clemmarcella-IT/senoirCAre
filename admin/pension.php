<?php require_once('includes/session.php'); 

// Handle QR Scan AJAX Request (Duplication Constraint)
if(isset($_POST['scanned_id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['scanned_id']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $time = date('H:i:s');

    // 1. Check if ID exists in Seniors table
    $checkUser = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo='$id'");
    if(mysqli_num_rows($checkUser) == 0) {
        echo "<script>alert('Error: Unregistered QR Code.'); window.location='pension.php';</script>";
        exit;
    }

    // 2. DUPLICATION CONSTRAINT CHECK (Cannot claim the same pension period twice)
    $checkDup = mysqli_query($conn, "SELECT * FROM pension WHERE OscaIDNo='$id' AND PensionReason='$reason'");
    if(mysqli_num_rows($checkDup) > 0) {
        echo "<script>alert('Duplicate: This Senior has already been recorded for the [ $reason ] payout.'); window.location='pension.php';</script>";
    } else {
        // 3. Insert Record
        mysqli_query($conn, "INSERT INTO pension (OscaIDNo, PensionReason, PensionAttendanceStatus, pensionTimeRecieve) 
                             VALUES ('$id', '$reason', '$status', '$time')");
        echo "<script>alert('Success: Pension marked as $status for $id.'); window.location='pension.php';</script>";
    }
    exit;
}

// Delete Logic
if(isset($_GET['delete'])) {
    $delID = mysqli_real_escape_string($conn, $_GET['delete']);
    mysqli_query($conn, "DELETE FROM pension WHERE PensionID='$delID'");
    header("Location: pension.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pension Records</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <h2 class="text-success fw-bold"><i class="fa fa-wallet me-2"></i> Pension Distribution Records</h2>
        
        <div class="card mt-4 mb-4 shadow-sm">
            <div class="card-header bg-success text-white fw-bold">Scan QR for Pension Payout</div>
            <div class="card-body row align-items-center">
                <!-- Camera Window -->
                <div class="col-md-5 text-center border-end">
                    <div id="reader" style="width: 100%; max-width: 350px; margin: 0 auto;"></div>
                </div>
                <!-- Manual Data Form -->
                <div class="col-md-7 ps-md-4">
                    <form method="POST" id="qrForm">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="fw-bold text-muted small">Scanned OscaIDNo.</label>
                                <input type="text" name="scanned_id" id="scanned_id" class="form-control form-control-lg text-primary fw-bold" placeholder="Waiting for scan..." readonly required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted small">Payout Period / Reason</label>
                                <input type="text" name="reason" class="form-control" placeholder="e.g., Q1 2026 Pension" required>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted small">Claim Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="Claimed">Claimed</option>
                                    <option value="Unclaimed">Unclaimed</option>
                                </select>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-success w-100 py-2" id="submitBtn" disabled>
                                    <i class="fa fa-save me-2"></i> Save Pension Record
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">Recent Pension Logs</div>
            <div class="card-body">
                <div class="table-responsive">
                <table id="datatablesSimple" class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr><th>Log ID</th><th>OscaIDNo.</th><th>Payout Period</th><th>Time Received</th><th>Status</th><th>Action</th></tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($conn, "SELECT * FROM pension ORDER BY PensionID DESC");
                        while($row = mysqli_fetch_assoc($q)): ?>
                        <tr>
                            <td><?php echo $row['PensionID']; ?></td>
                            <td><span class="badge bg-primary fs-6"><?php echo $row['OscaIDNo']; ?></span></td>
                            <td><?php echo $row['PensionReason']; ?></td>
                            <td><?php echo date("h:i A", strtotime($row['pensionTimeRecieve'])); ?></td>
                            <td>
                                <?php if($row['PensionAttendanceStatus'] == 'Claimed'): ?>
                                    <span class="badge bg-success">Claimed</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Unclaimed</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="pension.php?delete=<?php echo $row['PensionID']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this record?');"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </main>

    <!-- QR Scanner Logic -->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('scanned_id').value = decodedText;
            document.getElementById('submitBtn').disabled = false; 
            // Play a beep sound or show visual feedback here if desired
        }
        var html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>