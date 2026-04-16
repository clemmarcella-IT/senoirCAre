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
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-bold">PENSION PAYOUT MANAGEMENT</span>
                        <button type="button" class="btn btn-forest shadow-sm" data-bs-toggle="modal" data-bs-target="#addPensionModal">
                            <i class="fa fa-plus me-2"></i> Register New Payout
                        </button>
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow border-0">
                <div class="card-header bg-dark text-white fw-bold">Scheduled Payouts</div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-hover align-middle">
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
                            $query = mysqli_query($conn, "SELECT DISTINCT PensionReason, PensionDate, PensionCashAmount, PensionEventStatus FROM pension WHERE OscaIDNo IS NULL ORDER BY PensionDate DESC");
                            while ($display = mysqli_fetch_array($query)) {
                                $reason = $display['PensionReason'];
                                $date = $display['PensionDate'];
                                $uniqueID = md5($reason . $date);
                            ?>
                            <tr>
                                <td class="fw-bold"><?php echo date("M d, Y", strtotime($date)); ?></td>
                                <td class="text-primary fw-bold">₱<?php echo number_format($display['PensionCashAmount'], 2); ?></td>
                                <td>
                                    <span class="badge <?php echo ($display['PensionEventStatus'] == 'Active') ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $display['PensionEventStatus']; ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="pension_attendance.php?reason=<?php echo $reason; ?>&date=<?php echo $date; ?>" class="btn btn-sm btn-info">
                                            <i class="fa fa-qrcode"></i>
                                        </a>
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_pen_<?php echo $uniqueID; ?>">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del_pen_<?php echo $uniqueID; ?>">
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

    <!-- MODAL: ADD NEW SESSION (NO NAME FIELD) -->
    <div class="modal fade" id="addPensionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white"><h5 class="modal-title fw-bold">Start New Payout Session</h5></div>
                <form method="POST" action="query_add_pension.php">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Payout Date</label>
                            <input type="date" name="pdate" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Cash Amount (₱)</label>
                            <input type="number" step="0.01" name="pamount" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button><button type="submit" class="btn btn-success px-4 fw-bold">Create Session</button></div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>