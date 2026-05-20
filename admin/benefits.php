<?php 
include('includes/session.php'); 
include('../includes/db_connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Benefit Claims | SENIOR-CARE</title>
    <link href="../vendor/simple-datatables/css/style.min.css" rel="stylesheet" />
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/font-awesome/css/all.min.css">
    <link href="css/style.css" rel="stylesheet" />
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-4 mb-4">
                <div>
                    <h2 class="fw-bold text-success"><i class="fa fa-hand-holding-heart me-2"></i> Benefit Claims</h2>
                    <p class="text-muted mb-0">View benefit claim records and start a new claim by scanning a senior's QR code.</p>
                </div>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <a href="benefit_claim.php" class="btn btn-forest fw-bold shadow-sm w-100 w-sm-auto py-2">
                        <i class="fa fa-qrcode me-2"></i> New Claim
                    </a>
                    <button onclick="printTable()" class="btn btn-success fw-bold shadow-sm w-100 w-sm-auto py-2">
                        <i class="fa fa-print me-2"></i> Print
                    </button>
                </div>
            </div>

            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold">Benefit Claim History</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>OSCA ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Amount</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php
                            $query = mysqli_query($conn, "SELECT LogID, OscaIDNo, LastName, FirstName, DateRecorded, TimeRecorded, Amount_Released, Reason, Status FROM transaction_logs LEFT JOIN seniors USING(OscaIDNo) WHERE ClaimType = 'Benefit Claim' ORDER BY DateRecorded DESC, TimeRecorded DESC");
                            while ($row = mysqli_fetch_array($query)) {
                                $date = $row['DateRecorded'];
                                $time = $row['TimeRecorded'] ? date('h:i A', strtotime($row['TimeRecorded'])) : '--:--';
                                $amount = $row['Amount_Released'] ? number_format($row['Amount_Released'], 2) : '0.00';
                                $name = $row['FirstName'] . ' ' . $row['LastName'];
                            ?>
                            <tr>
                                <td><?php echo $row['OscaIDNo']; ?></td>
                                <td><?php echo $name ? $name : 'Unknown'; ?></td>
                                <td><?php echo date('M d, Y', strtotime($date)); ?></td>
                                <td><?php echo $time; ?></td>
                                <td>₱<?php echo $amount; ?></td>
                                <td><?php echo $row['Reason'] ? $row['Reason'] : '-'; ?></td>
                                <td>
                                    <span class="badge <?php echo ($row['Status'] == 'Claimed') ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo $row['Status'] ? $row['Status'] : 'Recorded'; ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['LogID']; ?>">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['LogID']; ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>

                                    <?php include('includes/benefit_modals.php'); ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/scripts.js"></script>
    <script src="../vendor/simple-datatables/js/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=900,height=800");
        newWindow.document.write("<html><head><title>Benefit Claims Report</title>");
        newWindow.document.write('<link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap.min.css">');
        newWindow.document.write("<style>body{padding:40px;font-family:sans-serif;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:10px;text-align:left;}th{background:#1F4B2C!important;color:white!important;text-transform:uppercase;font-size:12px;}</style>");
        newWindow.document.write("</head><body>");
        newWindow.document.write("<div style='text-align:center;border-bottom:2px solid #1F4B2C;padding-bottom:10px;margin-bottom:20px;'><h2>BARANGAY KALAWAG 1</h2><p style='margin:0;'>Benefit Claims Report</p></div>");
        if (table) {
            var tableClone = table.cloneNode(true);
            newWindow.document.write(tableClone.outerHTML);
        } else {
            newWindow.document.write('<p style="text-align:center;margin-top:30px;">No data found.</p>');
        }
        newWindow.document.write("</body></html>");
        newWindow.document.close();
        setTimeout(function() { newWindow.print(); newWindow.close(); }, 750);
    }
    </script>
</body>
</html>
