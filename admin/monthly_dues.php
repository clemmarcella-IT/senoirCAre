<?php include('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Monthly Dues | SENIOR-CARE</title>
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
            <h2 class="mt-4 fw-bold text-success"><i class="fa fa-money-bill-wave me-2"></i> Monthly Dues Management</h2>

            <div class="card mb-4 border-0 shadow-sm mt-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <span class="text-muted small fw-bold">DUES MANAGEMENT</span>
                    <button type="button" class="btn btn-forest shadow-sm" data-bs-toggle="modal" data-bs-target="#addDuesModal">
                        <i class="fa fa-plus me-2"></i> Add New Dues
                    </button>
                </div>
            </div>

            <!-- Dues Master List -->
            <div class="card mb-4 shadow border-0">
                <div class="card-header bg-dark text-white fw-bold">Contribution Schedule</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Contribution Name</th>
                                    <th>Amount Required</th>
                                    <th>Due Date</th>
                                    <th>Payments Made</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM monthly_dues_master ORDER BY Due_Date DESC");
                                while ($row = mysqli_fetch_array($query)) {
                                    $did = $row['DuesID'];

                                    // Count how many payments made for this dues
                                    $pcount_q = mysqli_query($conn, "SELECT * FROM dues_payments WHERE DuesID = '$did'");
                                    $pcount = 0;
                                    while(mysqli_fetch_array($pcount_q)) { $pcount++; }
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $row['Contribution_Name']; ?></td>
                                    <td class="text-success fw-bold">₱<?php echo number_format($row['Amount_Required'], 2); ?></td>
                                    <td><?php echo date("M d, Y", strtotime($row['Due_Date'])); ?></td>
                                    <td><span class="badge bg-primary"><?php echo $pcount; ?> paid</span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="dues_payments.php?id=<?php echo $did; ?>" class="btn btn-sm btn-info text-white" title="View Payments">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del_dues_<?php echo $did; ?>" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="del_dues_<?php echo $did; ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">Delete Dues Record</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center p-4">
                                                    <p>Delete <strong><?php echo $row['Contribution_Name']; ?></strong>?</p>
                                                    <p class="text-danger small">All payment records for this dues will also be deleted.</p>
                                                </div>
                                                <div class="modal-footer justify-content-center">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <a href="query_delete_dues.php?id=<?php echo $did; ?>" class="btn btn-danger">Confirm Delete</a>
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

            <!-- Recent Payments -->
            <div class="card mb-4 shadow border-0">
                <div class="card-header bg-success text-white fw-bold">Recent Payments</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>OscaIDNo.</th>
                                    <th>Contribution</th>
                                    <th>Amount Paid</th>
                                    <th>Date Paid</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $pq = mysqli_query($conn, "SELECT dues_payments.*, monthly_dues_master.Contribution_Name 
                                                           FROM dues_payments 
                                                           JOIN monthly_dues_master ON dues_payments.DuesID = monthly_dues_master.DuesID 
                                                           ORDER BY Date_Paid DESC");
                                while ($pr = mysqli_fetch_array($pq)) {
                                ?>
                                <tr>
                                    <td class="fw-bold text-primary"><?php echo $pr['OscaIDNo']; ?></td>
                                    <td><?php echo $pr['Contribution_Name']; ?></td>
                                    <td class="text-success fw-bold">₱<?php echo number_format($pr['Amount_Paid'], 2); ?></td>
                                    <td><?php echo date("M d, Y", strtotime($pr['Date_Paid'])); ?></td>
                                    <td><span class="badge bg-success"><?php echo $pr['Payment_Status']; ?></span></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Add Dues Modal -->
    <div class="modal fade" id="addDuesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold"><i class="fa fa-money-bill-wave me-2"></i> Add New Monthly Dues</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="query_add_dues.php">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Contribution Name</label>
                            <input type="text" name="cname" class="form-control card shadow border border-1 border-black" placeholder="e.g. Damayan Fund" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Amount Required (₱)</label>
                            <input type="number" name="amount" step="0.01" min="1" class="form-control card shadow border border-1 border-black" placeholder="e.g. 50.00" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Due Date</label>
                            <input type="date" name="due_date" class="form-control card shadow border border-1 border-black" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-bold">Save Dues</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>
