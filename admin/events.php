<?php include('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Events Management | SENIOR-CARE</title>
    
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
                <h2 class="mt-4 fw-bold text-success">Events & Activities</h2>
                
                <div class="card mb-4 border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                            <span class="text-muted small fw-bold mb-2 mb-md-0 text-center text-md-start">EVENTS MANAGEMENT</span>
                            <div class="d-flex flex-column flex-sm-row gap-2">
                                <button type="button" class="btn btn-forest shadow-sm w-100" data-bs-toggle="modal" data-bs-target="#addEventModal">
                                    <i class="fa fa-plus me-2"></i> Register New Event
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 shadow border-0">
                    <div class="card-header bg-dark text-white fw-bold">Scheduled Activities</div>
                    <div class="card-body">
                        <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Event Name</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                           <tbody>
    <?php
    $query = mysqli_query($conn, "SELECT * FROM events ORDER BY eventDate DESC");
    while ($display = mysqli_fetch_array($query)) {
        $eid = $display['EventID'];
    ?>
    <tr>
        <td class="fw-bold"><?php echo $display['EventName']; ?></td>
        <td><?php echo date("M d, Y", strtotime($display['eventDate'])); ?></td>
        <td><?php echo date("h:i A", strtotime($display['EventTime'])); ?></td>
        <td>
            <span class="badge <?php echo ($display['EventStatus'] == 'Active') ? 'bg-success' : 'bg-danger'; ?>">
                <?php echo $display['EventStatus']; ?>
            </span>
        </td>
        <td>
            <div class="btn-group">
                <a href="event_attendance.php?id=<?php echo $eid; ?>" class="btn btn-sm btn-info" title="Attendance">
                    <i class="fa fa-qrcode"></i>
                </a>
                <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#edit_event_<?php echo $eid; ?>">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#del_event_<?php echo $eid; ?>">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
            
            <!-- THE FIX: INCLUDE IS NOW INSIDE THE TD TAG -->
            <?php include("includes/event_modals.php"); ?>
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

    <!-- MODAL: ADD EVENT -->
    <div class="modal fade" id="addEventModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white"><h5>New Event Registration</h5></div>
                <form method="POST" action="query_add_event.php">
                    <div class="modal-body">
                        <div class="mb-3"><label class="small fw-bold mb-1">Event Name</label><input type="text" name="ename" class="form-control card shadow border border-1 border-black" required></div>
                        <div class="mb-3"><label class="small fw-bold mb-1">Date</label><input type="date" name="edate" class="form-control card shadow border border-1 border-black" value="<?php echo date('Y-m-d'); ?>" required></div>
                        <div class="mb-3"><label class="small fw-bold mb-1">Time Start</label><input type="time" name="etime" class="form-control card shadow border border-1 border-black" required></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Save Event</button>
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