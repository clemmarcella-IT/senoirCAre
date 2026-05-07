<?php include('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Benefit Claims | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <h2 class="mt-4 fw-bold text-success"><i class="fa fa-hand-holding-heart me-2"></i> Benefit Claims</h2>

            <div class="card mb-4 border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <span class="text-muted small fw-bold mb-2 mb-md-0 text-center text-md-start">BENEFIT DISTRIBUTION MANAGEMENT</span>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="button" class="btn btn-forest shadow-sm w-100" data-bs-toggle="modal" data-bs-target="#addBenefitModal">
                                <i class="fa fa-plus me-2"></i> Schedule Benefit Distribution
                            </button>
                            <button onclick="printTable()" class="btn btn-success fw-bold shadow-sm w-100">
                                <i class="fa fa-print me-2"></i> Print Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Benefit Distribution Events -->
            <div class="card mb-4 shadow border-0">
                <div class="card-header bg-dark text-white fw-bold">Benefit Distribution Events</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Claims Recorded</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM event_master WHERE EventType = 'Benefit Distribution' ORDER BY EventDate DESC");
                                while ($row = mysqli_fetch_array($query)) {
                                    $eid = $row['EventID'];

                                    // Count claims for this event
                                    $cq = mysqli_query($conn, "SELECT * FROM transaction_records WHERE EventID = '$eid' AND Transaction_Type = 'Benefit_Claim'");
                                    $ccount = 0;
                                    while(mysqli_fetch_array($cq)) { $ccount++; }
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $row['EventName']; ?></td>
                                    <td><?php echo date("M d, Y", strtotime($row['EventDate'])); ?></td>
                                    <td>
                                        <span class="badge <?php echo ($row['EventStatus'] == 'Active') ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $row['EventStatus']; ?>
                                        </span>
                                    </td>
                                    <td><span class="badge bg-info text-dark"><?php echo $ccount; ?> claims</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="benefit_claims_list.php?id=<?php echo $eid; ?>" class="btn btn-sm btn-info text-white" title="View Claims">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del_ben_<?php echo $eid; ?>" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="del_ben_<?php echo $eid; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Delete Benefit Event</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center p-4">
                                                    <p>Delete <strong><?php echo $row['EventName']; ?></strong>?</p>
                                                    <p class="text-danger small">All claim records for this event will also be deleted.</p>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="query_delete_event.php?id=<?php echo $eid; ?>" class="btn btn-danger">Confirm Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Recent Benefit Claims -->
            <div class="card mb-4 shadow border-0">
                <div class="card-header bg-success text-white fw-bold">Recent Benefit Claims</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>OscaIDNo.</th>
                                    <th>Event</th>
                                    <th>Control No.</th>
                                    <th>Date Claimed</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rq = mysqli_query($conn, "SELECT transaction_records.*, event_master.EventName 
                                                           FROM transaction_records 
                                                           JOIN event_master ON transaction_records.EventID = event_master.EventID 
                                                           WHERE Transaction_Type = 'Benefit_Claim' 
                                                           ORDER BY Date_Recorded DESC");
                                while ($rr = mysqli_fetch_array($rq)) {
                                ?>
                                <tr>
                                    <td class="fw-bold text-primary"><?php echo $rr['OscaIDNo']; ?></td>
                                    <td><?php echo $rr['EventName']; ?></td>
                                    <td><?php echo $rr['ControlNo'] ? $rr['ControlNo'] : '—'; ?></td>
                                    <td><?php echo date("M d, Y", strtotime($rr['Date_Recorded'])); ?></td>
                                    <td><span class="badge bg-success"><?php echo $rr['Status']; ?></span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add Benefit Distribution Modal -->
    <div class="modal fade" id="addBenefitModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="fa fa-hand-holding-heart me-2"></i> Schedule Benefit Distribution</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="query_add_event.php">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Event Name</label>
                            <input type="text" name="ename" class="form-control card shadow border border-1 border-black" placeholder="e.g. Emergency Aid Distribution" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Date</label>
                            <input type="date" name="edate" class="form-control card shadow border border-1 border-black" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Time</label>
                            <input type="time" name="etime" class="form-control card shadow border border-1 border-black">
                        </div>
                        <input type="hidden" name="etype" value="Benefit Distribution">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-bold">Save Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=900,height=800");
        newWindow.document.write("<html><head><title>Benefit Claims Report</title>");
        newWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">');
        newWindow.document.write("<style>body{padding:40px;font-family:sans-serif;}table{width:100%;border-collapse:collapse;margin-top:20px;}th,td{border:1px solid #ddd;padding:10px;text-align:left;}th{background:#1F4B2C!important;color:white!important;text-transform:uppercase;font-size:12px;}</style>");
        newWindow.document.write("</head><body>");
        newWindow.document.write("<div style='text-align:center;border-bottom:2px solid #1F4B2C;padding-bottom:10px;margin-bottom:20px;'><h2>BARANGAY KALAWAG 1</h2><p style='margin:0;'>Benefit Claims Report</p></div>");
        if (table) {
            var tableClone = table.cloneNode(true);
            var rows = tableClone.rows;
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].cells.length > 0) rows[i].deleteCell(-1);
            }
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
