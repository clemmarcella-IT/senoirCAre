<?php 
require_once('includes/session.php'); 
$pid = $_GET['id'];

<<<<<<< HEAD
$res = mysqli_query($conn, "SELECT * FROM pension WHERE PensionReason = '$preason' AND PensionDate = '$pdate' AND OscaIDNo IS NULL");
$event = mysqli_fetch_array($res);
if (!$event) {
    $event =[
        'PensionReason' => $preason,
        'PensionDate' => $pdate,
        'PensionCashAmount' => 0,
        'PensionEventStatus' => 'Active'
    ];
=======
$res = mysqli_query($conn, "SELECT PensionMasterID, PayoutDate, CashAmount FROM pension_master WHERE PensionMasterID = '$pid'");
$payout = mysqli_fetch_array($res);
if (!$payout) {
    echo "<script>alert('Pension payout not found.'); window.location='pension.php';</script>";
    exit;
>>>>>>> newrevisesystem
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pension Claim | Pension Payout</title>
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
                    <h3 class="fw-bold text-success m-0">Pension Payout</h3>
                    <p class="text-muted mb-1"><?php echo date("M d, Y", strtotime($payout['PayoutDate'])); ?> | ₱<?php echo number_format($payout['CashAmount'], 2); ?></p>
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="pension.php" class="btn btn-secondary shadow-sm w-100 py-2">Back</a>
                    <button onclick="printTable()" class="btn btn-success shadow-sm w-100 py-2"><i class="fa fa-print me-2"></i>Print</button>
                </div>
            </div>

            <div class="row">
                <!-- LEFT: SCANNER -->
                <div class="col-md-4">
                    <div class="card p-3 shadow-sm border-0">
                        <div class="card-header bg-success text-white fw-bold text-center mb-3">Live QR Scanner</div>
                        <div id="reader"></div>
                        <form action="query_record_pension_attendance.php" method="POST" class="mt-3" id="pensionScannerForm">
                            <input type="hidden" name="pid" value="<?php echo $payout['PensionMasterID']; ?>">
                            <input type="text" name="oscaID" id="scanned_id" class="form-control text-center font-weight-bold text-primary mb-2" readonly placeholder="Waiting for Scan">
                            <button type="submit" id="submitBtn" class="btn btn-success w-100 py-2 fw-bold" disabled>MARK AS CLAIMED</button>
                        </form>
                    </div>
                </div>

                <!-- RIGHT: MASTER LIST -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white font-weight-bold">Pension Master List</div>
                        <div class="card-body">
                            <div class="table-responsive">
<<<<<<< HEAD
                            <table class="table table-bordered table-hover align-middle" id="datatablesSimple">
                                <thead class="table-light">
                                    <tr>
                                        <th>PayoutNo.</th>
                                        <th>OscaIDNo.</th>
                                        <th>Name</th>
                                        <th>Time Claimed</th>
                                        <th>Status</th>
                                        <th>Control No.</th>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                         $clem = mysqli_query($conn, "SELECT seniors.OscaIDNo, seniors.LastName, seniors.FirstName, pension.pensionTimeRecieve, pension.PensionAttendanceStatus, pension.PensionReason, pension.ControlNo 
                                                                      FROM seniors 
                                                                      LEFT JOIN pension ON seniors.OscaIDNo = pension.OscaIDNo 
                                                                      AND pension.PensionReason = '$preason' 
                                                                      AND pension.PensionDate = '$pdate' 
                                                                      WHERE seniors.CitizenStatus = 'active'
                                                                      ORDER BY pension.pensionTimeRecieve DESC, seniors.LastName ASC");
                                         
                                         $counter = 1;
                                         while($display = mysqli_fetch_array($clem)){
                                            
                                            // Handle status checking and assignments
                                            $status = $display['PensionAttendanceStatus'];
                                            $controlNo = $display['ControlNo'];
                                            
                                            if ($controlNo == "" || $controlNo == null) {
                                                $displayControl = "-";
                                                $modalControl = "";
                                            } else {
                                                $displayControl = $controlNo;
                                                $modalControl = $controlNo;
                                            }

                                            if ($status == 'Claimed' || $status == 'claimed') {
                                                $statusText = '<span class="badge bg-success">CLAIMED</span>';
                                                
                                                $pensionTime = $display['pensionTimeRecieve'];
                                                if ($pensionTime != "" && $pensionTime != null) {
                                                    $time = date("h:i A", strtotime($pensionTime));
                                                } else {
                                                    $time = '-- : --';
                                                }
                                                
                                                $reasonText = "";
                                                $modalReason = "";
                                            } else if ($status != "" && $status != "Unclaimed" && $status != null) {
                                                $statusText = '<span class="badge bg-danger">UNCLAIMED</span>';
                                                $time = '-- : --';
                                                $reasonText = $status; // Show typed reason here
                                                $modalReason = $status;
                                            } else {
                                                $statusText = '<span class="badge bg-danger">UNCLAIMED</span>';
                                                $time = '-- : --';
                                                $reasonText = "";
                                                $modalReason = "";
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-muted fw-bold"><?php echo $counter++; ?>.</td>
                                                <td class="fw-bold"><?php echo $display['OscaIDNo']; ?></td>
                                                <td><?php echo $display['LastName'].", ".$display['FirstName']; ?></td>
                                                <td><?php echo $time; ?></td>
                                                <td><?php echo $statusText; ?></td>
                                                <td class="fw-bold text-primary"><?php echo $displayControl; ?></td>
                                                <td class="fw-bold text-danger"><?php echo $reasonText; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reasonModal_<?php echo $display['OscaIDNo']; ?>">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                                    <?php include("includes/pension_reason_modal.php"); ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                </tbody>
                            </table>
=======
                            <table class="table table-bordered table-hover align-middle" id="datatablesSimple" width="100%" cellspacing="0">
    <thead class="table-light">
        <tr>
            <th>PayoutNo.</th>
            <th>OscaIDNo.</th>
            <th>Name</th>
            <th>Time Claimed</th>
            <th>Status</th>
            <th>Control No.</th>
            <th>Reason</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
         <?php
             $clem = mysqli_query($conn, "SELECT seniors.OscaIDNo, seniors.LastName, seniors.FirstName, transaction_logs.DateRecorded, transaction_logs.TimeRecorded, transaction_logs.Status, transaction_logs.Reason, transaction_logs.ControlNo 
                                          FROM seniors 
                                          LEFT JOIN transaction_logs ON seniors.OscaIDNo = transaction_logs.OscaIDNo 
                                          AND transaction_logs.PensionMasterID = '$pid' 
                                          AND transaction_logs.ClaimType = 'Pension Claim' 
                                          WHERE seniors.PensionerStatus = 'Pensioner'
                                          ORDER BY transaction_logs.DateRecorded DESC, transaction_logs.TimeRecorded DESC, seniors.LastName ASC");
             
             $counter = 1;
             while($display = mysqli_fetch_array($clem)){
                $status = $display['Status'];
                
                if ($status == "Claimed") {
                    $statusText = '<span class="badge bg-success">CLAIMED</span>';
                    $time = $display['TimeRecorded'] ? date("h:i A", strtotime($display['TimeRecorded'])) : "-- : --";
                } else {
                    $statusText = '<span class="badge bg-danger">UNCLAIMED</span>';
                    $time = "-- : --";
                }

                $reasonText = $display['Reason'] ? $display['Reason'] : '-';
                $controlText = $display['ControlNo'] ? $display['ControlNo'] : '-';
                ?>
                <tr>
                    <td class="text-muted fw-bold"><?php echo $counter++; ?>.</td>
                    <td class="fw-bold"><?php echo $display['OscaIDNo']; ?></td>
                    <td><?php echo $display['LastName']; ?>, <?php echo $display['FirstName']; ?></td>
                    <td><?php echo $time; ?></td>
                    <td><?php echo $statusText; ?></td>
                    <td class="fw-bold text-primary"><?php echo $controlText; ?></td>
                    <td class="fw-bold text-danger"><?php echo $reasonText; ?></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#reasonModal_<?php echo $display['OscaIDNo']; ?>">
                            <i class="fa fa-edit"></i>
                        </button>
                        <?php include("includes/pension_reason_modal.php"); ?>
                    </td>
                </tr>
            <?php } ?>
    </tbody>
</table>
>>>>>>> newrevisesystem
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

<script src="js/scripts.js"></script>
<script src="js/qr_scanner_logic.js?v=<?php echo time(); ?>"></script>
<script>startScanner();</script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script>
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=800,height=600");
        newWindow.document.write("<html><head><title>Print</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'></head><body>");
        newWindow.document.write("<h3 class='text-center'>Pension Payout</h3>");
        newWindow.document.write(table.outerHTML);
        newWindow.document.close();
        setTimeout(() => { 
            newWindow.print(); 
            newWindow.close(); 
        }, 500);
    }
</script>
</body>
</html>