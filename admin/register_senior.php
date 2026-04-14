<?php require_once('includes/session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | Register Senior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="d-flex bg-light">

    <?php include('includes/sidebar.php'); ?>

    <main id="main-content" class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-success"><i class="fa fa-user-plus me-2"></i> Register New Citizen</h2>
            <a href="profiling.php" class="btn btn-outline-dark"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold py-3">Senior Citizen Data Entry</div>
            <div class="card-body p-4">
                
                <form id="seniorForm" action="query_add_senior.php" method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="fw-bold small">OscaIDNo. (Primary Key)</label>
                            <input type="text" class="form-control" name="oscaID" placeholder="Numeric ID" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required/>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold small">Sex</label>
                            <select class="form-select" name="sex" required><option value="Male">Male</option><option value="Female">Female</option></select>
                        </div>
                        <div class="col-md-4">
                            <label class="fw-bold small">Status</label>
                            <select class="form-select" name="status"><option value="active">Active</option><option value="inactive">Inactive</option></select>
                        </div>

                        <div class="col-md-4"><label class="small fw-bold">First Name</label><input type="text" class="form-control" name="fname" required/></div>
                        <div class="col-md-4"><label class="small fw-bold">Middle Name</label><input type="text" class="form-control" name="mi"/></div>
                        <div class="col-md-4"><label class="small fw-bold">Last Name</label><input type="text" class="form-control" name="lname" required/></div>

                        <div class="col-md-4"><label class="small fw-bold">Purok</label>
                            <select class="form-select" name="purok" required>
                                <?php for($i=1; $i<=6; $i++) echo "<option value='Zone $i'>Zone $i</option>"; ?>
                            </select>
                        </div>
                        <div class="col-md-4"><label class="small fw-bold">Barangay</label><input type="text" class="form-control" name="brgy" value="Kalawag 1" readonly/></div>
                        <div class="col-md-4">
                            <label class="small fw-bold">Birthday</label>
                            <input type="date" class="form-control" name="bday" required/>
                        </div>

                        <div class="col-12 mt-4 border-top pt-3">
                            <label class="fw-bold text-success mb-2">1. PROFILE PICTURE</label>
                            <input type="file" class="form-control" name="pic" accept="image/*" required/>
                            <small class="text-danger">White background required.</small>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="fw-bold text-success mb-2">2. THREE SIGNATURES</label>
                            <input type="file" class="form-control mb-1" name="sig1" required/>
                            <input type="file" class="form-control mb-1" name="sig2" required/>
                            <input type="file" class="form-control" name="sig3" required/>
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="fw-bold text-success mb-2">3. THREE THUMBMARKS</label>
                            <input type="file" class="form-control mb-1" name="thumb1" required/>
                            <input type="file" class="form-control mb-1" name="thumb2" required/>
                            <input type="file" class="form-control" name="thumb3" required/>
                        </div>
                    </div>
                    <button type="submit" class="btn-save-custom mt-4 py-3">SAVE & REGISTER CITIZEN</button>
                </form>
            </div>
        </div>
    </main>
    <script src="js/scripts.js"></script>
</body>
</html> 