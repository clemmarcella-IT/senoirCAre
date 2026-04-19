<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Senior Profiling | Admin</title>
    
    <!-- External CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- YOUR MASTER DESIGN CSS -->
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
    
    <!-- Required Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="sb-nav-fixed">

    <!-- Design: Topbar and Mobile Overlay -->
    <?php include('includes/header.php'); ?>

    <!-- Design: Sidebar Menu -->
    <?php include('includes/sidebar.php'); ?>

    <!-- UX: Main Content Wrapper -->
    <main id="main-content">
        <div class="container-fluid px-4">
            <h2 class="mt-4 fw-bold text-success"><i class="fa fa-users me-2"></i> Senior Citizen Profiling</h2>
            
            <!-- Action Bar -->
            <div class="card mb-4 border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
                        <span class="text-muted small fw-bold mb-2 mb-md-0 text-center text-md-start">MASTER LIST MANAGEMENT</span>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <!-- Design: Your requested Forest Green Register Button -->
                            <button type="button" class="btn btn-forest shadow-sm w-100" onclick="window.location.href='register_senior.php'">
                                 <i class="fa fa-user-plus me-2"></i> Register New Senior
                            </button>
                            <!-- Design: Green Print Button -->
                            <button type="button" class="btn btn-success fw-bold shadow-sm w-100" style="border-radius: 8px;" onclick="printTable()">
                                <i class="fa fa-print me-2"></i> Print Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Card -->
            <div class="card mb-4 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header py-3">
                    <i class="fas fa-table me-1"></i> Official Master List of Enrolled Seniors
                </div>
                <div class="card-body bg-white">
                    <!-- UX: Search and Pagination are handled by 'datatablesSimple' ID -->
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Photo</th>
                                <th>OscaIDNo.</th>
                                <th>Full Name</th>
                                <th>Sex</th>
                                <th>Purok</th>
                                <th>Status</th>
                                <th class="no-print">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM seniors ORDER BY GenerateDate DESC");
                            while ($row = mysqli_fetch_array($query)) {
                                $id = $row['OscaIDNo'];
                            ?>
                            <tr>
                                <td>
                                    <!-- UX: Clicking photo opens full details page -->
                                    <a href="view_senior_details.php?id=<?php echo $id; ?>">
                                        <img src="../uploads/<?php echo $row['Picture']; ?>" style="width:45px; height:45px; border-radius:50%; object-fit:cover; border:2px solid var(--forest-deep);">
                                    </a>
                                </td>
                                <td class="fw-bold text-primary"><?php echo $id; ?></td>
                                <td>
                                    <a href="view_senior_details.php?id=<?php echo $id; ?>" class="text-dark fw-bold text-decoration-none text-uppercase">
                                        <?php echo $row['LastName'].", ".$row['FirstName']; ?>
                                    </a>
                                </td>
                                <td><?php echo $row['Sex']; ?></td>
                                <td><?php echo $row['Purok']; ?></td>
                                <td>
                                    <span class="badge <?php echo ($row['CitizenStatus'] == 'active') ? 'bg-success' : 'bg-danger'; ?> text-uppercase" style="font-size: 0.75rem; padding: 6px 12px;">
                                        <?php echo $row['CitizenStatus']; ?>
                                    </span>
                                </td>
                                <td class="no-print">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $id; ?>"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete_<?php echo $id; ?>"><i class="fa fa-trash"></i></button>
                                    </div>
                                </td>
                                <!-- Load Update/Delete Popups -->
                                <?php include("includes/senior_modals.php"); ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- UX: Sidebar Toggle and Link Highlighting -->
    <script src="js/scripts.js"></script>
    
    <!-- UX: DataTables Search/Pagination Engine -->
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>

    <!-- UX: Professional Report Printing Logic -->
    <script>
    function printTable() {
        var table = document.getElementById("datatablesSimple");
        var newWindow = window.open("", "", "width=900,height=800");
        newWindow.document.write("<html><head><title>Print Report</title>");
        newWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">');
        newWindow.document.write("<style>body{padding:40px; font-family: sans-serif;} table{width:100%; border-collapse:collapse; margin-top:20px;} th,td{border:1px solid #ddd; padding:10px; text-align:left;} th{background:#1F4B2C !important; color:white !important; text-transform: uppercase; font-size: 12px;} .empty{margin-top:30px; text-align:center; color:#555;}</style>");
        newWindow.document.write("</head><body>");
        newWindow.document.write("<div style='text-align:center; border-bottom: 2px solid #1F4B2C; padding-bottom:10px; margin-bottom:20px;'><h2>BARANGAY KALAWAG 1</h2><p style='margin:0;'>Senior Citizen Master List Enrollment Report</p></div>");
        if (table) {
            var tableClone = table.cloneNode(true);
            var rows = tableClone.rows;
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].cells.length > 0) rows[i].deleteCell(-1);
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