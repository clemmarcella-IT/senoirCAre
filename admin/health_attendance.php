<?php 
require_once('includes/session.php'); 
$hname = $_GET['name'];
$hdate = $_GET['date'];

$res = mysqli_query($conn, "SELECT * FROM healthrecords WHERE HealthName = '$hname' AND HealthDate = '$hdate' AND OscaIDNo IS NULL");
$event = mysqli_fetch_array($res);
if (!$event) {
    $event = [
        'HealthName' => $hname,
        'HealthPurpose' => 'Unknown',
        'HealthDate' => $hdate,
        'HealthEventStatus' => 'Active'
    ];
}

$isStopped = ($event['HealthEventStatus'] == 'Stopped');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Health Attendance | <?php echo $event['HealthName']; ?></title>
    
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
                    <h3 class="fw-bold text-success m-0"><?php echo $event['HealthName']; ?></h3>
                    <p class="text-muted mb-1"><?php echo $event['HealthPurpose']; ?> | <?php echo date("M d, Y", strtotime($hdate)); ?></p>
                    <span class="badge <?php echo $isStopped ? 'bg-danger' : 'bg-success'; ?>">
                        <?php echo $isStopped ? 'CLOSED (VIEW ONLY)' : 'ACTIVE SESSION'; ?>
                    </span>
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="health.php" class="btn btn-secondary shadow-sm w-100">Back</a>
                    <button onclick="printTable()" class="btn btn-success shadow-sm w-100"><i class="fa fa-print"></i> Print</button>
                    <?php if(!$isStopped): ?>
                        <a href="query_stop_health.php?name=<?php echo $hname; ?>&date=<?php echo $hdate; ?>" 
                           class="btn btn-danger fw-bold shadow-sm w-100" onclick="return confirm('Stop permanently?')">
                           STOP ATTENDANCE
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
                    <form action="query_record_health_attendance.php" method="POST" class="mt-3">
                        <input type="hidden" name="hname" value="<?php echo $event['HealthName']; ?>">
                        <input type="hidden" name="hdate" value="<?php echo $event['HealthDate']; ?>">
                        <input type="hidden" name="hpurpose" value="<?php echo $event['HealthPurpose']; ?>">
                        <input type="text" name="oscaID" id="scanned_id" class="form-control text-center font-weight-bold text-primary mb-2" readonly placeholder="Waiting for Scan">
                        <button type="submit" id="submitBtn" class="btn btn-success w-100 py-2 fw-bold" disabled>MARK AS PRESENT</button>
                    </form>
                </div>
            <?php else: ?>
                <div class="alert alert-dark text-center py-5 shadow-sm">
                    <i class="fa fa-lock fa-3x mb-3 opacity-50"></i>
                    <h5 class="fw-bold">Attendance Closed</h5>
                </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT: ATTENDANCE LIST -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white font-weight-bold">Present Master List</div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>OscaIDNo.</th>
                                <th>Senior Name</th>
                                <th>Time In</th>
                                <th>Status Attendance</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php
                                 $clem=mysqli_query($conn, "SELECT *
                                 FROM healthrecords
                                 LEFT JOIN seniors ON seniors.OscaIDNo = healthrecords.OscaIDNo 
                                 WHERE healthrecords.HealthName = '$hname' 
                                 AND healthrecords.HealthDate = '$hdate' 
                                 AND healthrecords.OscaIDNo IS NOT NULL
                                 ORDER BY healthrecords.HealthTimeIn DESC");
                                 
                                while($display = mysqli_fetch_array($clem)){
                                    ?>
                                    <tr>
                                    <td class="fw-bold"><?php echo $display['OscaIDNo']; ?></td>
                                     <td><?php echo $display['LastName'].", ".$display['FirstName']; ?></td>
                                     <td><?php echo date("h:i A", strtotime($display['HealthTimeIn'])); ?></td>
                                     <td><span class="text-success fw-bold">PRESENT</span></td>
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
        newWindow.document.write("<html><head><title>Print Report</title><link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'></head><body>");
        newWindow.document.write("<h3 class='text-center'>Health Activity: <?php echo $event['HealthName']; ?></h3>");
        if (table) {
            newWindow.document.write(table.outerHTML);
        } else {
            newWindow.document.write("<p class='text-center mt-4'>No records found to print.</p>");
        }
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        setTimeout(() => { newWindow.print(); 
        newWindow.close(); },
         500);
    }
</script>
</body>
</html>