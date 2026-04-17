<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Event Popularity | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    
    <!-- DataTables CSS -->
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
                <h2 class="mb-0">Most Attended Events</h2>
                <a href="reports.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Reports
                </a>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-star me-1"></i> Event Attendance Ranking
                </div>
                <div class="card-body">
                    <p class="text-muted small">This report shows which events have the highest number of participants.</p>
                    <table id="example" class="table table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>Rank (#)</th>
                                <th>Event Name</th>
                                <th>Total Attendees</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include("../includes/db_connection.php");

                            /* 
                               LOGIC:
                               1. We JOIN events and attendance.
                               2. We GROUP BY EventName so each event appears only once.
                               3. We COUNT the attendance records for that event.
                               4. We ORDER BY the count DESC (Highest to Lowest).
                            */
                            $query = mysqli_query($conn, "SELECT events.EventName, COUNT(attendance.AttendanceID) AS total_attendees 
                                                         FROM events 
                                                         LEFT JOIN attendance ON events.EventID = attendance.EventID 
                                                         GROUP BY events.EventID 
                                                         ORDER BY total_attendees DESC");

                            $clem = 1; // Counter for the Rank column

                            while ($display = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?php echo $clem++; ?></td>
                                <td><?php echo $display['EventName']; ?></td>
                                <td>
                                    <span class="badge <?php echo ($display['total_attendees'] > 0) ? 'bg-success' : 'bg-secondary'; ?>">
                                        <?php echo $display['total_attendees']; ?> People
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