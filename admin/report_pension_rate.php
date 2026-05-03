<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pension Summary | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            
            <!-- HEADER WITH BACK BUTTON -->
            <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                <h2 class="mb-0">Pension Summary (Per Person)</h2>
                <a href="reports.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Reports
                </a>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-line me-1"></i> Pension Claim Rates per Senior
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Senior Name</th>
                                <th>Total Payouts</th>
                                <th>Total Claimed</th>
                                <th>Claim Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("../includes/db_connection.php");

                            // SQL Logic: Grouping by person to show lifetime totals per senior
                           $query = mysqli_query($conn, "SELECT seniors.FirstName, seniors.LastName,
                            COUNT(event_attendance.AttendanceID) AS total_claimed FROM seniors 
                            LEFT JOIN event_attendance ON seniors.OscaIDNo = event_attendance.OscaIDNo LEFT JOIN event_master 
                           ON event_attendance.EventID = event_master.EventID 
                           AND event_master.EventType = 'Pension' GROUP BY seniors.OscaIDNo");

                            $clem = 1; // Counter for the # column

                            while ($display = mysqli_fetch_array($query)) {
                                $total = $display['total_claimed'];
                                $claimed = $display['total_claimed'];
                                
                                // Calculate Percentage
                                if ($total > 0) {
                                    $rate = 100;
                                    $rate_display = "100%";
                                } else {
                                    $rate = 0;
                                    $rate_display = "0%";
                                }
                            ?>
                            <tr>
                                <td><?php echo $clem++; ?></td>
                                <td><?php echo $display['FirstName'] . " " . $display['LastName']; ?></td>
                                <td><?php echo $total; ?></td>
                                <td><?php echo $claimed; ?></td>
                                <td>
                                    <!-- Dynamic Badge Color based on rate -->
                                    <span class="badge <?php echo ($rate >= 100) ? 'bg-success' : (($rate > 0) ? 'bg-warning' : 'bg-danger'); ?>">
                                        <?php echo $rate_display; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: ['print', 'csv', 'excel', 'pdf']
            });
        });
    </script>
</body>
</html>