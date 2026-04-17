<?php include('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Assistance Records | SENIOR-CARE</title>
    
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
            <h2 class="mt-4 fw-bold text-success">Assistance Records</h2>
            
            <div class="card mb-4 border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <span class="text-muted small fw-bold mb-2 mb-md-0 text-center text-md-start">ASSISTANCE MANAGEMENT</span>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="button" class="btn btn-forest shadow-sm w-100" data-bs-toggle="modal" data-bs-target="#addAssistanceModal">
                                <i class="fa fa-plus me-2"></i> Register New Assistance
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow border-0">
                <div class="card-header bg-dark text-white fw-bold">Scheduled Assistances</div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="datatablesSimple" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Assistance Name</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                       <tbody>
    <?php
    $query = mysqli_query($conn, "SELECT DISTINCT AssistanceName, AssistanceDate, TypeAssistance, AssistanceEventStatus FROM assistance WHERE OscaIDNo IS NULL ORDER BY AssistanceDate DESC");
    while ($display = mysqli_fetch_array($query)) {
        $aname = $display['AssistanceName'];
        $adate = $display['AssistanceDate'];
        $uniqueID = md5($aname . $adate);
    ?>
    <tr>
        <td class="fw-bold"><?php echo $display['AssistanceName']; ?></td>
        <td><?php echo $display['TypeAssistance']; ?></td>
        <td><?php echo date("M d, Y", strtotime($display['AssistanceDate'])); ?></td>
        <td>
            <span class="badge <?php echo ($display['AssistanceEventStatus'] == 'Active') ? 'bg-success' : 'bg-danger'; ?>">
                <?php echo $display['AssistanceEventStatus']; ?>
            </span>
        </td>
        <td>
            <div class="btn-group">
                <a href="assistance_attendance.php?name=<?php echo $aname; ?>&date=<?php echo $adate; ?>" class="btn btn-sm btn-info" title="Attendance">
                    <i class="fa fa-qrcode"></i>
                </a>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_ast_<?php echo $uniqueID; ?>" title="Edit Assistance">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del_ast_<?php echo $uniqueID; ?>" title="Delete Assistance">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            
            <!-- THE FIX: PUT INCLUDE INSIDE THIS TD TAG -->
            <?php include("includes/assistance_modals.php"); ?>
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

    <!-- MODAL: ADD NEW ASSISTANCE -->
    <div class="modal fade" id="addAssistanceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">New Assistance Registration</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="query_add_assistance.php">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Assistance Name</label>
                            <input type="text" name="aname" class="form-control card shadow border border-1 border-black" required placeholder="e.g. Relief Goods Distribution">
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Date</label>
                            <input type="date" name="adate" class="form-control card shadow border border-1 border-black" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mb-1">Type of Assistance</label>
                            <select name="atype" class="form-select card shadow border border-1 border-black" required>
                                <option value="Food Packs">Food Packs</option>
                                <option value="Non-Food">Non-Food</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 bg-light">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold">Save Assistance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>