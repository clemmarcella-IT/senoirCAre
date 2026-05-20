<?php 
require_once('includes/session.php'); 
$aid = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM activities WHERE ActivityID = '$aid'");
$activity = mysqli_fetch_array($res);
if (!$activity) {
    echo "<script>alert('Activity not found.'); window.location='activity.php';</script>";
    exit;
}

$isStopped = ($activity['ActivityStatus'] == 'Stopped');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Attendance | <?php echo $activity['ActivityName']; ?></title>
    
    <link href="../vendor/simple-datatables/css/style.min.css" rel="stylesheet" />
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/font-awesome/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />

    <script src="../vendor/jquery/jquery.slim.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/html5-qrcode/html5-qrcode.min.js"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 mb-4 gap-3">
                <div>
                    <h3 class="fw-bold text-success m-0"><?php echo $activity['ActivityName']; ?></h3>
                    <span class="badge <?php echo $isStopped ? 'bg-danger' : 'bg-success'; ?>">
                        <?php echo $isStopped ? 'CLOSED (VIEW ONLY)' : 'ACTIVE SESSION'; ?>
                    </span>
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="activity.php" class="btn btn-secondary shadow-sm w-100">Back</a>
                    <button onclick="printTable()" class="btn btn-success shadow-sm w-100"><i class="fa fa-print"></i> Print</button>
                    <?php if(!$isStopped): ?>
                        <a href="query_stop_activity.php?id=<?php echo $aid; ?>" 
                           class="btn btn-danger fw-bold shadow-sm w-100" onclick="return confirm('Stop permanently?')">
                           STOP ATTENDANCE
                        </a>
                    <?php endif; ?>
                </div>
            </div>

    <div class="row">
       
        <div class="col-md-4">
            <?php if(!$isStopped): ?>
                <div class="card p-3 shadow-sm border-0">
                    <div id="reader"></div>
                        <form action="query_record_activity_attendance.php" method="POST" class="mt-3">
                        <input type="hidden" name="activity_id" value="<?php echo $aid; ?>">
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

        
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white font-weight-bold">Attendees Master List</div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>OscaIDNo.</th>
                                <th>Senior Name</th>
                                <th>Time In</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <?php
                        $list = mysqli_query($conn, "SELECT transaction_logs.OscaIDNo, LastName, FirstName, TimeRecorded FROM transaction_logs LEFT JOIN seniors ON transaction_logs.OscaIDNo = seniors.OscaIDNo WHERE ActivityID = '$aid' ORDER BY TimeRecorded DESC");
                        while($display = mysqli_fetch_array($list)){
                        ?>
                        <tr>
                            <td><?php echo $display['OscaIDNo']; ?></td>
                            <td><?php echo $display['LastName'].", ".$display['FirstName']; ?></td>
                            <td><?php echo $display['TimeRecorded'] ? date("h:i A", strtotime($display['TimeRecorded'])) : '--:--'; ?></td>
                            <td><span class="text-success fw-bold">PRESENT</span></td>
                        </tr>
                        <?php } ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
        </div>
    </main>

<script src="js/scripts.js"></script>
<script src="js/qr_scanner_logic.js?v=<?php echo time(); ?>"></script>
<?php if(!$isStopped): ?>
    <script>startScanner();</script>
<?php endif; ?>

<script src="../vendor/simple-datatables/js/simple-datatables.min.js"></script>
<script src="js/datatables-simple-demo.js"></script>
<script>
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=800,height=600");
        newWindow.document.write("<html><head><title>Print</title><link rel='stylesheet' href='../vendor/bootstrap/css/bootstrap.min.css'></head><body>");
        newWindow.document.write("<h3 class='text-center'>Attendance: <?php echo $activity['ActivityName']; ?></h3>");
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