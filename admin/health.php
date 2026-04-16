<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Health Events | SENIOR-CARE</title>
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
                <h2 class="mt-4 fw-bold text-success">Health Activity Management</h2>
                
                <div class="card mb-4 border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <span class="text-muted small fw-bold mb-2 mb-md-0 text-center text-md-start">HEALTH EVENTS MANAGEMENT</span>
                            <div class="d-flex flex-column flex-sm-row gap-2">
                                <button type="button" class="btn btn-forest shadow-sm w-100" data-bs-toggle="modal" data-bs-target="#addhealth">
                                    <i class="fa fa-plus me-2"></i> Create Health Event
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header bg-dark text-white fw-bold">Scheduled Health Activities</div>
                    <div class="card-body bg-white">
                        <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // 1. Connect to database
                                    include("../includes/db_connection.php");

                                    // 2. SQL to get the list of events
                                    $query = mysqli_query($conn, "SELECT HealthName, HealthDate, HealthPurpose, HealthEventStatus, MIN(HealthRecordID) as first_id 
                                                                  FROM healthrecords 
                                                                  GROUP BY HealthName, HealthDate 
                                                                  ORDER BY HealthDate DESC");
                                    
                                    // 3. Simple loop to show data
                                    while($display = mysqli_fetch_array($query)){
                                        $uniqueID = $display['first_id'];
                                        $row = $display; // This helps your modals file work correctly
                                    ?>
                                    <tr>
                                        <td class="fw-bold"><?php echo $display['HealthName']; ?></td>
                                        <td><?php echo date("M d, Y", strtotime($display['HealthDate'])); ?></td>
                                        <td><?php echo $display['HealthPurpose']; ?></td>
                                        <td>
                                        <span class="badge <?php echo ($display['HealthEventStatus'] == 'Active') ? 'bg-success' : 'bg-danger'; ?>">
                                            <?php echo $display['HealthEventStatus']; ?>
                                        </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="health_attendance.php?name=<?php echo urlencode($display['HealthName']); ?>&date=<?php echo $display['HealthDate']; ?>&purpose=<?php echo urlencode($display['HealthPurpose']); ?>" class="btn btn-sm btn-info">
                                                    <i class="fa fa-qrcode"></i>
                                                </a>
                                                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_event_<?php echo $uniqueID; ?>">
                                                    <i class="fa fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del_event_<?php echo $uniqueID; ?>">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <?php include("includes/health_modals.php"); ?>
                                    </tr>
                                <?php
                                    } // End of while loop
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <!-- MODAL: ADD NEW HEALTH EVENT -->
    <div class="modal fade" id="addhealth" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold">Register Health Event</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="GET" action="health_attendance.php">
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted">EVENT NAME</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted">DATE</label>
                            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="small fw-bold text-muted">PURPOSE</label>
                            <select name="purpose" class="form-select" required>
                                <option value="Check up">Check up</option>
                                <option value="Giving a medicine">Giving a medicine</option>
                                <option value="Both">Both</option>
                                <option value="Others medication">Others medication</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success px-4">Start Scanning</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
</html>