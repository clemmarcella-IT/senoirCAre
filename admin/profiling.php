<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Senior Profiling | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="container-fluid px-4">
            <h2 class="mt-4 fw-bold text-success"><i class="fa fa-users me-2"></i> Senior Citizen Profiling</h2>
            
            <div class="card mb-4 border-0 shadow-sm mt-3">
                <div class="card-body d-flex justify-content-between">
                    <span class="text-muted small fw-bold">MASTER LIST</span>
                    <button type="button" class="btn btn-register-main" onclick="window.location.href='register_senior.php'">
                         <i class="fa fa-user-plus me-2"></i> Register New Senior
                    </button>
                </div>
            </div>

            <div class="card mb-4 shadow border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-dark text-white fw-bold">Official Master List</div>
                <div class="card-body bg-white">
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
                                <td><span class="badge <?php echo ($row['CitezenStatus'] == 'active') ? 'bg-success' : 'bg-danger'; ?>"><?php echo strtoupper($row['CitezenStatus']); ?></span></td>
                                <td class="no-print">
                                    <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#edit_<?php echo $id; ?>"><i class="fa fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-target="#delete_<?php echo $id; ?>"><i class="fa fa-trash"></i></button>
                                </td>
                                <?php include("includes/senior_modals.php"); ?>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="js/scripts.js"></script>
</body>
</html>