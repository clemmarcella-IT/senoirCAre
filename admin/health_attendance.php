<?php 
require_once('includes/session.php'); 

// 1. Capture Event Details from URL
$hName = $_GET['name'];
$hDate = $_GET['date'];
$hPurpose = isset($_GET['purpose']) ? $_GET['purpose'] : '';
$hTime = isset($_GET['time']) ? $_GET['time'] : date('H:i:s');

// 2. Check Event Status from Database
$statusCheck = mysqli_query($conn, "SELECT HealthEventStatus FROM healthrecords WHERE HealthName='$hName' AND HealthDate='$hDate' LIMIT 1");
$rowStatus = mysqli_fetch_assoc($statusCheck);
$isStopped = ($rowStatus && $rowStatus['HealthEventStatus'] == 'Stopped');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Attendance | <?php echo $hName; ?></title>
<<<<<<< HEAD
    
=======

>>>>>>> origin/branch4
    <!-- CSS Dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
<<<<<<< HEAD
    
    <!-- Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
=======

    <!-- Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

>>>>>>> origin/branch4
    <!-- QR Library -->
    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
<<<<<<< HEAD
                
                <!-- Header Section -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 mb-4 gap-3">
                    <div>
                        <h2 class="fw-bold text-success m-0"><?php echo $hName; ?></h2>
                        <p class="text-muted mb-0"><?php echo date("F d, Y", strtotime($hDate)); ?> | <?php echo $hPurpose; ?></p>
                        <span class="badge <?php echo $isStopped ? 'bg-danger' : 'bg-success'; ?>">
                            <?php echo $isStopped ? 'CLOSED (VIEW ONLY)' : 'ACTIVE SESSION'; ?>
                        </span>
                    </div>
                    <div class="no-print d-flex flex-column flex-sm-row gap-2">
                        <a href="health.php" class="btn btn-secondary shadow-sm w-100">Back</a>
                        
                        <!-- Print Report Button -->
                        <button class="btn btn-success shadow-sm w-100" onclick="printAttendance()">
                            <i class="fa fa-print"></i> Print Report
                        </button>

                        <?php if(!$isStopped): ?>
                            <a href="query_stop_health.php?name=<?php echo urlencode($hName); ?>&date=<?php echo $hDate; ?>" 
                               class="btn btn-danger fw-bold shadow-sm w-100" 
                               onclick="return confirm('Stop attendance permanently?')">
                                STOP ATTENDANCE
                            </a>
                        <?php endif; ?>
                    </div>
=======

            <!-- Header Section -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mt-4 mb-4 gap-3">
                <div>
                    <h2 class="fw-bold text-success m-0"><?php echo $hName; ?></h2>
                    <p class="text-muted mb-0"><?php echo date("F d, Y", strtotime($hDate)); ?> | <?php echo $hPurpose; ?></p>
                    <span class="badge <?php echo $isStopped ? 'bg-danger' : 'bg-success'; ?>">
                        <?php echo $isStopped ? 'CLOSED (VIEW ONLY)' : 'ACTIVE SESSION'; ?>
                    </span>
>>>>>>> origin/branch4
                </div>
                <div class="no-print d-flex flex-column flex-sm-row gap-2">
                    <a href="health.php" class="btn btn-secondary shadow-sm w-100">Back</a>
                    <button class="btn btn-success shadow-sm w-100" onclick="printAttendance()">
                        <i class="fa fa-print"></i> Print Report
                    </button>
                    <?php if(!$isStopped): ?>
                        <a href="query_stop_health.php?name=<?php echo urlencode($hName); ?>&date=<?php echo $hDate; ?>" 
                           class="btn btn-danger fw-bold shadow-sm w-100" 
                           onclick="return confirm('Stop attendance permanently?')">
                           STOP ATTENDANCE
                        </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row g-3">
                <!-- LEFT COLUMN: SCANNER AREA (Hidden if Stopped) -->
                <div class="col-md-4">
                    <?php if(!$isStopped): ?>
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-header bg-success text-white py-2">Live Scanner</div>
                            <div class="card-body">
                                <div id="reader" style="width: 100%;"></div>
                                <form action="query_record_attendance.php" method="POST" class="mt-3">
                                    <input type="hidden" name="hname" value="<?php echo $hName; ?>">
                                    <input type="hidden" name="hdate" value="<?php echo $hDate; ?>">
                                    <input type="hidden" name="hpurpose" value="<?php echo $hPurpose; ?>">
                                    <input type="hidden" name="htime" value="<?php echo date('H:i:s'); ?>">
                                    
                                    <label class="small fw-bold">Detected ID:</label>
                                    <input type="text" name="oscaID" id="scanned_id" class="form-control text-center fw-bold text-primary mb-3" readonly placeholder="Wait for Scan">
                                    <button type="submit" id="submitBtn" class="btn btn-success w-100 py-2 fw-bold" disabled>RECORD PRESENT</button>
                                </form>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-dark text-center py-5 shadow-sm">
                            <i class="fa fa-lock fa-3x mb-3 opacity-50"></i>
                            <h5 class="fw-bold">Attendance Locked</h5>
                            <p class="small m-0">This event has been concluded.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- RIGHT COLUMN: ATTENDANCE LIST -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-dark text-white fw-bold">Present Attendees</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatablesSimple" class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>OscaIDNo.</th>
                                            <th>Senior Name</th>
                                            <th>Time In</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $list = mysqli_query($conn, "SELECT *
                                                                        FROM  healthrecords
                                                                        inner JOIN seniors on seniors.OscaIDNo = healthrecords.OscaIDNo
                                                                        WHERE healthrecords.HealthName = '$hName'
                                                                        AND healthrecords.HealthDate = '$hDate'
                                                                        ORDER BY healthrecords.HealthTimeIn DESC");
                                            while($display = mysqli_fetch_array($list)){
                                        ?>
                                        <tr>
                                            <td><?php echo $display['OscaIDNo']; ?></td>
                                            <td><?php echo $display['LastName'].", ".$display['FirstName']; ?></td>
                                            <td><?php echo date("h:i A", strtotime($display['HealthTimeIn'])); ?></td>
                                            <td><span class="badge bg-success"><?php echo $display['HealthAttendanceStatus']; ?></span></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<<<<<<< HEAD
                </div> <!-- End Row -->
=======
                </div>
            </div><!-- End Row -->

>>>>>>> origin/branch4
        </div>
    </main>

    <!-- Scripts -->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    
    <?php if(!$isStopped): ?>
        <script src="js/qr_scanner_logic.js"></script>
        <script>startScanner();</script>
    <?php endif; ?>

    <!-- PRINT LOGIC -->
    <script>
    function printAttendance() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=800,height=600");
        
        newWindow.document.write("<html><head><title>Attendance Report</title>");
        newWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">');
        newWindow.document.write("<style>body{padding:40px; font-family:sans-serif;} table{width:100%; border-collapse:collapse;} th,td{border:1px solid #ddd; padding:8px;} th{background:#1F4B2C !important; color:white !important; text-transform:uppercase;}</style>");
        newWindow.document.write("</head><body>");
        
        newWindow.document.write("<div class='text-center mb-4'>");
        newWindow.document.write("<h2>BARANGAY KALAWAG 1</h2>");
        newWindow.document.write("<h4>Health Activity Attendance Report</h4>");
        newWindow.document.write("<p class='m-0'><strong>Activity:</strong> <?php echo $hName; ?></p>");
        newWindow.document.write("<p class='m-0'><strong>Date:</strong> <?php echo date('F d, Y', strtotime($hDate)); ?></p>");
        newWindow.document.write("</div>");
        
        newWindow.document.write(table.outerHTML);
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        
        newWindow.focus();
        setTimeout(function() {
            newWindow.print();
            newWindow.close();
        }, 750);
    }
    </script>
</body>
</html>