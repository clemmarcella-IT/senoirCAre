<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pension Management | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <h2 class="mt-4 fw-bold text-success">Pension Distribution</h2>
            
            <div class="card mb-4 border-0 shadow-sm mt-3">
                <div class="card-body">
                    <!-- UPDATED LAYOUT TO EXACTLY MATCH HEALTH.PHP -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <span class="text-muted small fw-bold mb-2 mb-md-0 text-center text-md-start">PENSION PAYOUT MANAGEMENT</span>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="button" class="btn btn-forest shadow-sm w-100" data-bs-toggle="modal" data-bs-target="#addPensionModal">
                                <i class="fa fa-plus me-2"></i> Register New Payout
                            </button>
                            <button type="button" class="btn btn-success fw-bold shadow-sm w-100" style="border-radius: 8px;" onclick="printTable()">
                                <i class="fa fa-print me-2"></i> Print Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-dark text-white fw-bold">Scheduled Payouts</div>
                <div class="card-body bg-white">
                    <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT event_master.EventID, event_master.EventName, event_master.EventDate, event_master.EventStatus, pension_details.CashAmount FROM event_master LEFT JOIN pension_details ON event_master.EventID = pension_details.EventID WHERE event_master.EventType = 'Pension' ORDER BY event_master.EventDate DESC");
                            while ($display = mysqli_fetch_array($query)) {
                                $eid = $display['EventID'];
                                $date = $display['EventDate'];
                            ?>
                            <tr>
                                <td class="fw-bold"><?php echo date("M d, Y", strtotime($date)); ?></td>
                                <td class="text-primary fw-bold">₱<?php echo number_format($display['CashAmount'], 2); ?></td>
                                <td>
                                    <span class="badge <?php echo ($display['EventStatus'] == 'Active') ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $display['EventStatus']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="pension_attendance.php?id=<?php echo $eid; ?>" class="btn btn-sm btn-info">
                                            <i class="fa fa-qrcode"></i>
                                        </a>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_pen_<?php echo $eid; ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del_pen_<?php echo $eid; ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <?php include("includes/pension_modals.php"); ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL: ADD NEW SESSION -->
    <div class="modal fade" id="addPensionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Start New Payout Session</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="query_add_pension.php">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Payout Date</label>
                            <input type="date" name="pdate" class="form-control card shadow border border-1 border-black" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Cash Amount (₱)</label>
                            <input type="number" step="0.01" name="pamount" class="form-control card shadow border border-1 border-black" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold">Create Session</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script>
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=900,height=800");
        newWindow.document.write("<html><head><title>Print Report</title>");
        newWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">');
        newWindow.document.write("<style>body{padding:40px; font-family: sans-serif;} table{width:100%; border-collapse:collapse; margin-top:20px;} th,td{border:1px solid #ddd; padding:10px; text-align:left;} th{background:#1F4B2C !important; color:white !important; text-transform: uppercase; font-size: 12px;} .empty{margin-top:30px; text-align:center; color:#555;}</style>");
        newWindow.document.write("</head><body>");
        newWindow.document.write("<div style='text-align:center; border-bottom: 2px solid #1F4B2C; padding-bottom:10px; margin-bottom:20px;'><h2>BARANGAY KALAWAG 1</h2><p style='margin:0;'>Pension Payout Report</p></div>");
        if (table) {
            var tableClone = table.cloneNode(true);
            var rows = tableClone.rows;
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].cells.length > 0) rows[i].deleteCell(-1); // Delete the action column
            }
            newWindow.document.write(tableClone.outerHTML);
        } else {
            newWindow.document.write('<p class="empty">No data found to print.</p>');
        }
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