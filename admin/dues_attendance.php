<?php 
require_once('includes/session.php'); 
$did = $_GET['id'];

$res = mysqli_query($conn, "SELECT * FROM monthly_dues_master WHERE DuesID = '$did'");
$dues = mysqli_fetch_array($res);

if (!$dues) {
    echo "<script>alert('Dues record not found.'); window.location='monthly_dues.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Dues Attendance | <?php echo $dues['Contribution_Name']; ?></title>
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
        <div class="container-fluid px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 mb-4 gap-3">
                <div>
                    <h3 class="fw-bold text-success m-0"><?php echo $dues['Contribution_Name']; ?></h3>
                    <p class="text-muted mb-1">Due Date: <?php echo date("M d, Y", strtotime($dues['Due_Date'])); ?> | Required: ₱<?php echo number_format($dues['Amount_Required'], 2); ?></p>
                    <span class="badge bg-success">ACTIVE COLLECTION</span>
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="monthly_dues.php" class="btn btn-secondary shadow-sm w-100">Back</a>
                    <button onclick="printTable()" class="btn btn-success shadow-sm w-100"><i class="fa fa-print"></i> Print Details</button>
                </div>
            </div>

            <div class="row">
                <!-- LEFT: SCANNER -->
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm border-0">
                        <div class="alert alert-info py-2 small fw-bold text-center">Scanning activates their Citizen Status</div>
                        <div id="reader"></div>
                        <form action="query_record_dues_attendance.php" method="POST" class="mt-3">
                            <input type="hidden" name="dues_id" value="<?php echo $did; ?>">
                            <input type="hidden" name="amount" value="<?php echo $dues['Amount_Required']; ?>">
                            <input type="text" name="oscaID" id="scanned_id" class="form-control text-center font-weight-bold text-primary mb-2" readonly placeholder="Waiting for Scan">
                            <button type="submit" id="submitBtn" class="btn btn-success w-100 py-2 fw-bold" disabled>RECORD PAYMENT</button>
                        </form>
                    </div>
                </div>

                <!-- RIGHT: ATTENDANCE/PAYMENT LIST -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white font-weight-bold">Collection & Attendance Master List</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>OscaIDNo.</th>
                                            <th>Senior Name</th>
                                            <th>Time Paid</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $list = mysqli_query($conn, "SELECT dp.*, s.FirstName, s.LastName 
                                                                    FROM dues_payments dp 
                                                                    INNER JOIN seniors s ON s.OscaIDNo = dp.OscaIDNo 
                                                                    WHERE dp.DuesID = '$did'
                                                                    ORDER BY dp.Date_Paid DESC, dp.Time_Paid DESC");
                                        while($display = mysqli_fetch_array($list)){
                                        ?>
                                        <tr>
                                            <td class="fw-bold text-primary"><?php echo $display['OscaIDNo']; ?></td>
                                            <td><?php echo $display['LastName'].", ".$display['FirstName']; ?></td>
                                            <td><?php echo date("M d", strtotime($display['Date_Paid'])) . " | " . date("h:i A", strtotime($display['Time_Paid'])); ?></td>
                                            <td class="text-success fw-bold">₱<?php echo number_format($display['Amount_Paid'], 2); ?></td>
                                            <td><span class="badge bg-success">PAID</span></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script src="js/scripts.js"></script>
<script src="js/qr_scanner_logic.js"></script>
<script>startScanner();</script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script>
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=800,height=600");
        newWindow.document.write("<html><head><title>Print</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'></head><body>");
        newWindow.document.write("<h3 class='text-center'>Dues Collection: <?php echo $dues['Contribution_Name']; ?></h3>");
        if (table) {
            newWindow.document.write(table.outerHTML);
        } else {
            newWindow.document.write("<p class='text-center mt-4'>No records found to print.</p>");
        }
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        setTimeout(() => { newWindow.print(); newWindow.close(); }, 500);
    }
</script>
</body>
</html>