<?php 
require_once('includes/session.php'); 
$preason = $_GET['reason'];
$pdate = $_GET['date'];

$res = mysqli_query($conn, "SELECT * FROM pension WHERE PensionReason = '$preason' AND PensionDate = '$pdate' AND OscaIDNo IS NULL");
$event = mysqli_fetch_array($res);

$isStopped = ($event['PensionEventStatus'] == 'Stopped');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pension Claim | <?php echo $event['PensionReason']; ?></title>
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
                    <h3 class="fw-bold text-success m-0"><?php echo $event['PensionReason']; ?></h3>
                    <p class="text-muted mb-1"><?php echo date("M d, Y", strtotime($event['PensionDate'])); ?> | ₱<?php echo number_format($event['PensionCashAmount'], 2); ?></p>
                    <span class="badge <?php echo $isStopped ? 'bg-warning text-dark' : 'bg-success'; ?>">
                        <?php echo $isStopped ? 'PAUSED (LOCKED)' : 'ACTIVE DISTRIBUTION'; ?>
                    </span>
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="pension.php" class="btn btn-secondary shadow-sm">Back</a>
                    <button onclick="printTable()" class="btn btn-success shadow-sm"><i class="fa fa-print"></i> Print</button>
                    <?php if(!$isStopped): ?>
                        <a href="query_toggle_pension.php?reason=<?php echo $preason; ?>&date=<?php echo $pdate; ?>&status=Stopped" 
                           class="btn btn-warning fw-bold shadow-sm" onclick="return confirm('Pause distribution?')">PAUSE</a>
                    <?php else: ?>
                        <a href="query_toggle_pension.php?reason=<?php echo $preason; ?>&date=<?php echo $pdate; ?>&status=Active" 
                           class="btn btn-primary fw-bold shadow-sm" onclick="return confirm('Resume distribution?')">RESUME</a>
                    <?php endif; ?>
                    <button class="btn btn-danger fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#stopPermanentlyModal">STOP PERMANENTLY</button>
                </div>
            </div>

            <div class="row">
                <!-- LEFT: SCANNER -->
                <div class="col-md-4">
                    <?php if(!$isStopped): ?>
                        <div class="card p-3 shadow-sm border-0">
                            <div class="card-header bg-success text-white fw-bold text-center mb-3">Live QR Scanner</div>
                            <div id="reader"></div>
                            <form action="query_record_pension_attendance.php" method="POST" class="mt-3">
                                <input type="hidden" name="preason" value="<?php echo $event['PensionReason']; ?>">
                                <input type="hidden" name="pdate" value="<?php echo $event['PensionDate']; ?>">
                                <input type="hidden" name="pamount" value="<?php echo $event['PensionCashAmount']; ?>">
                                <input type="text" name="oscaID" id="scanned_id" class="form-control text-center font-weight-bold text-primary mb-2" readonly placeholder="Waiting for Scan">
                                <button type="submit" id="submitBtn" class="btn btn-success w-100 py-2 fw-bold" disabled>MARK AS CLAIMED</button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center py-5 shadow-sm border-0">
                            <i class="fa fa-pause-circle fa-3x mb-3 text-warning"></i>
                            <h5 class="fw-bold text-dark">Distribution is Paused</h5>
                            <p class="small text-dark m-0">Click <b>RESUME</b> at the top to re-open the scanner.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- RIGHT: MASTER LIST -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white font-weight-bold">Pension Master List</div>
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle" id="datatablesSimple">
                                <thead class="table-light">
                                    <tr>
                                        <th>PayoutNo.</th>
                                        <th>OscaIDNo.</th>
                                        <th>Name</th>
                                        <th>Time Claimed</th>
                                        <th>Status</th>
                                        <th>Control No.</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                         $clem = mysqli_query($conn, "SELECT seniors.OscaIDNo, seniors.LastName, seniors.FirstName, pension.pensionTimeRecieve, pension.PensionAttendanceStatus, pension.PensionReason, pension.ControlNo, pension.PayOutNo 
                                                                      FROM seniors 
                                                                      LEFT JOIN pension ON seniors.OscaIDNo = pension.OscaIDNo 
                                                                      AND pension.PensionReason = '$preason' 
                                                                      AND pension.PensionDate = '$pdate' 
                                                                      WHERE seniors.CitezenStatus = 'active'
                                                                      ORDER BY pension.pensionTimeRecieve DESC, seniors.LastName ASC");
                                         
                                         $counter = 1; // Initialize sequence counter
                                         while($display = mysqli_fetch_array($clem)){
                                            if ($display['PensionAttendanceStatus'] == 'Claimed') {
                                                $statusText = '<span class="badge bg-success">CLAIMED</span>';
                                                $time = date("h:i A", strtotime($display['pensionTimeRecieve']));
                                            } elseif (!empty($display['PensionReason'])) {
                                                $statusText = '<span class="badge bg-secondary">'.$display['PensionReason'].'</span>';
                                                $time = '-- : --';
                                            } else {
                                                $statusText = '<span class="badge bg-danger">UNCLAIMED</span>';
                                                $time = '-- : --';
                                            }
                                            ?>
                                            <tr>
                                                <td class="text-muted fw-bold"><?php echo $counter++; ?>.</td>
                                                <td class="fw-bold"><?php echo $display['OscaIDNo']; ?></td>
                                                <td><?php echo $display['LastName'].", ".$display['FirstName']; ?></td>
                                                <td><?php echo $time; ?></td>
                                                <td><?php echo $statusText; ?></td>
                                                <td class="fw-bold text-primary"><?php echo $display['ControlNo'] ?? '-'; ?></td>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal fade" id="stopPermanentlyModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title fw-bold">Stop Permanently</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <i class="fa fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                            <p class="fw-bold">Are you sure you want to end this session?</p>
                            <p class="text-muted small">To record reasons for absentees (e.g. Bedridden), please use the <b>Edit</b> icon in the list.</p>
                            
                            <form action="query_stop_pension.php" method="POST">
                                <!-- Hidden context inputs -->
                                <input type="hidden" name="preason" value="<?php echo $event['PensionReason']; ?>">
                                <input type="hidden" name="pdate" value="<?php echo $event['PensionDate']; ?>">
                                <input type="hidden" name="pamount" value="<?php echo $event['PensionCashAmount']; ?>">
                                
                                <div class="d-grid gap-2 mt-3">
                                    <button type="submit" class="btn btn-danger fw-bold">Confirm & Stop</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </modal>

<script src="js/scripts.js"></script>
<script src="js/qr_scanner_logic.js"></script>
<?php if(!$isStopped): ?>
    <script>startScanner();</script>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="js/datatables-simple-demo.js"></script>
<script>
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=800,height=600");
        newWindow.document.write("<html><head><title>Print</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'></head><body>");
        newWindow.document.write("<h3 class='text-center'>Pension: <?php echo $event['PensionReason']; ?></h3>");
        newWindow.document.write(table.outerHTML);
        newWindow.document.close();
        setTimeout(() => { newWindow.print(); newWindow.close(); }, 500);
    }
</script>
</body>
</html>