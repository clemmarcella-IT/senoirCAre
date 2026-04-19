<?php 
require_once('includes/session.php'); 
$aname = $_GET['name'];
$adate = $_GET['date'];

$res = mysqli_query($conn, "SELECT * FROM assistance WHERE AssistanceName = '$aname' AND AssistanceDate = '$adate' AND OscaIDNo IS NULL");
$event = mysqli_fetch_array($res);
if (!$event) {
    $event = [
        'AssistanceName' => $aname,
        'TypeAssistance' => 'Unknown',
        'AssistanceDate' => $adate,
        'AssistanceEventStatus' => 'Active'
    ];
}

$isStopped = ($event['AssistanceEventStatus'] == 'Stopped');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Assistance Distribution | <?php echo $event['AssistanceName']; ?></title>
    
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
                    <h3 class="fw-bold text-success m-0"><?php echo $event['AssistanceName']; ?></h3>
                    <p class="text-muted mb-1"><?php echo $event['TypeAssistance']; ?> | <?php echo date("M d, Y", strtotime($adate)); ?></p>
                    <span class="badge <?php echo $isStopped ? 'bg-warning text-dark' : 'bg-success'; ?>">
                        <?php echo $isStopped ? 'PAUSED (LOCKED)' : 'ACTIVE DISTRIBUTION'; ?>
                    </span>
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="assistance.php" class="btn btn-secondary shadow-sm w-100">Back</a>
                    <button onclick="printTable()" class="btn btn-success shadow-sm w-100"><i class="fa fa-print"></i> Print</button>
                    
                    <!-- THE FIX: PAUSE AND RESUME TOGGLE BUTTONS -->
                    <?php if(!$isStopped): ?>
                        <a href="query_toggle_assistance.php?name=<?php echo $aname; ?>&date=<?php echo $adate; ?>&status=Stopped" 
                           class="btn btn-warning fw-bold shadow-sm w-100" onclick="return confirm('Pause distribution for now?')">
                           <i class="fa fa-pause"></i> PAUSE
                        </a>
                    <?php else: ?>
                        <a href="query_toggle_assistance.php?name=<?php echo $aname; ?>&date=<?php echo $adate; ?>&status=Active" 
                           class="btn btn-primary fw-bold shadow-sm w-100" onclick="return confirm('Resume distribution for late office claims?')">
                           <i class="fa fa-play"></i> RESUME
                        </a>
                    <?php endif; ?>

                </div>
            </div>

    <div class="row">
        <!-- LEFT: SCANNER -->
        <div class="col-md-4">
            <?php if(!$isStopped): ?>
                <div class="card p-3 shadow-sm border-0">
                    <div id="reader"></div>
                    <form action="query_record_assistance_attendance.php" method="POST" class="mt-3">
                        <input type="hidden" name="aname" value="<?php echo $event['AssistanceName']; ?>">
                        <input type="hidden" name="adate" value="<?php echo $event['AssistanceDate']; ?>">
                        <input type="hidden" name="atype" value="<?php echo $event['TypeAssistance']; ?>">
                        <input type="text" name="oscaID" id="scanned_id" class="form-control text-center font-weight-bold text-primary mb-2" readonly placeholder="Waiting for Scan">
                        <button type="submit" id="submitBtn" class="btn btn-success w-100 py-2 fw-bold" disabled>MARK AS CLAIMED</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center py-5 shadow-sm border-0">
                    <i class="fa fa-pause-circle fa-3x mb-3 text-warning"></i>
                    <h5 class="fw-bold text-dark">Distribution is Paused</h5>
                    <p class="small text-dark m-0">Click the <b>RESUME</b> button at the top to re-open the scanner for office claiming.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT: MASTER LIST (ALL ACTIVE SENIORS) -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white font-weight-bold">Assistance Master List (Active Seniors)</div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="datatablesSimple" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th>OscaIDNo.</th>
                                <th>Senior Name</th>
                                <th>Time Claimed</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                                 $clem = mysqli_query($conn, "SELECT seniors.OscaIDNo, seniors.LastName, seniors.FirstName, assistance.AssistanceTimeIn 
                                                              FROM seniors 
                                                              LEFT JOIN assistance ON seniors.OscaIDNo = assistance.OscaIDNo 
                                                              AND assistance.AssistanceName = '$aname' 
                                                              AND assistance.AssistanceDate = '$adate' 
                                                              WHERE seniors.CitizenStatus = 'active'
                                                              ORDER BY assistance.AssistanceTimeIn DESC, seniors.LastName ASC");
                                 
                                while($display = mysqli_fetch_array($clem)){
                                    
                                    if ($display['AssistanceTimeIn'] != NULL) {
                                        $status = '<span class="badge bg-success">CLAIMED</span>';
                                        $time = date("h:i A", strtotime($display['AssistanceTimeIn']));
                                    } else {
                                        $status = '<span class="badge bg-danger">UNCLAIMED</span>';
                                        $time = '-- : --';
                                    }
                                    ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo $display['OscaIDNo']; ?></td>
                                        <td><?php echo $display['LastName'].", ".$display['FirstName']; ?></td>
                                        <td><?php echo $time; ?></td>
                                        <td><?php echo $status; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
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
        newWindow.document.write("<h3 class='text-center'>Assistance: <?php echo $event['AssistanceName']; ?></h3>");
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