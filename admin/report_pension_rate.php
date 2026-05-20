<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Pension Summary | Admin</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/font-awesome/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    
    <link rel="stylesheet" href="../vendor/datatables-buttons/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../vendor/datatables-buttons/css/buttons.dataTables.min.css">
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            
          
            <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                <h2 class="mb-0">Pension Summary (Per Person)</h2>
                <a href="reports.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Reports
                </a>
            </div>
            
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-list me-1"></i> List of Pensioners
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered nowrap" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>OscaIDNo</th>
                                    <th>Last Name</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Purok</th>
                                    <th>Barangay</th>
                                </tr>
                            </thead>
                            <?php
                            include("../includes/db_connection.php");
                            $clem = mysqli_query($conn, "SELECT OscaIDNo, LastName, FirstName, MiddleName, Purok, Barangay FROM seniors WHERE PensionerStatus = 'Pensioner' ORDER BY LastName ASC");
                            while($display = mysqli_fetch_array($clem)){
                            ?>
                            <tr>
                                <td><?php echo $display['OscaIDNo']; ?></td>
                                <td><?php echo $display['LastName']; ?></td>
                                <td><?php echo $display['FirstName']; ?></td>
                                <td><?php echo $display['MiddleName']; ?></td>
                                <td><?php echo $display['Purok']; ?></td>
                                <td><?php echo $display['Barangay']; ?></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/datatables-buttons/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendor/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="../vendor/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendor/jszip/jszip.min.js"></script>
    <script src="../vendor/pdfmake/pdfmake.min.js"></script>
    <script src="../vendor/pdfmake/vfs_fonts.js"></script>
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