<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Health Events | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <div id="layoutSidenav_content">
        <main id="main-content">
            <div class="container-fluid px-4">
                <h2 class="mt-4 fw-bold text-success">Health Activity Management</h2>
                
                <!-- Top Action Bar -->
                <div class="card mb-4 border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <span style="float: right;">
                            <button type="button" class="btn btn-register-main" data-toggle="modal" data-target="#addhealth">
                                <i class="fa fa-plus"></i> Create Health Event
                            </button>
                            
                        </span>
                    </div>
                </div>

                <!-- Events Table -->
                <div class="card mb-4 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-header bg-dark text-white fw-bold">Scheduled Health Activities</div>
                    <div class="card-body bg-white">
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
                                // Grouping by Name and Date to treat them as an Event
                                $query = mysqli_query($conn, "SELECT HealthName, HealthDate, HealthPurpose, HealthEventStatus, MIN(HealthRecordID) as first_id 
                                                              FROM healthrecords 
                                                              GROUP BY HealthName, HealthDate 
                                                              ORDER BY HealthDate DESC");
                                while ($row = mysqli_fetch_array($query)) {
                                    $uniqueID = $row['first_id'];
                                ?>
                                <tr>
                                    <td class="fw-bold"><?php echo $row['HealthName']; ?></td>
                                    <td><?php echo date("M d, Y", strtotime($row['HealthDate'])); ?></td>
                                    <td><?php echo $row['HealthPurpose']; ?></td>
                                    <td>
                                        <span class="badge <?php echo ($row['HealthEventStatus'] == 'Active') ? 'badge-success' : 'badge-danger'; ?>">
                                            <?php echo strtoupper($row['HealthEventStatus']); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <!-- Go to Attendance/Scanner -->
                                            <a href="health_attendance.php?name=<?php echo urlencode($row['HealthName']); ?>&date=<?php echo $row['HealthDate']; ?>&purpose=<?php echo urlencode($row['HealthPurpose']); ?>" class="btn btn-sm btn-info" title="Scan QR">
                                                <i class="fa fa-qrcode"></i>
                                            </a>
                                            <!-- Edit Event Details -->
                                            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#edit_event_<?php echo $uniqueID; ?>">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <!-- Delete Whole Event -->
                                            <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#del_event_<?php echo $uniqueID; ?>">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <!-- Include Modals for this row -->
                                    <?php include("includes/health_modals.php"); ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL: ADD NEW HEALTH EVENT -->
    <div class="modal fade" id="addhealth" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title font-weight-bold">Register Health Event</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                </div>
                <form method="GET" action="health_attendance.php">
                    <div class="modal-body p-4">
                        <div class="form-group">
                            <label class="small fw-bold text-muted">EVENT NAME</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Annual Medical Checkup" required>
                        </div>
                        <div class="form-group">
                            <label class="small fw-bold text-muted">DATE</label>
                            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="small fw-bold text-muted">PURPOSE</label>
                            <select name="purpose" class="form-control" required>
                                <option value="Check up">Check up</option>
                                <option value="Giving a medicine">Giving a medicine</option>
                                <option value="Both">Both (Checkup & Medicine)</option>
                                <option value="Others medication">Others medication</option>
                            </select>
                        </div>
                        <input type="hidden" name="time" value="<?php echo date('H:i'); ?>">
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Start Scanning</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>