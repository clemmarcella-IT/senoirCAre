<!DOCTYPE html>
<?php include "include.php"; ?>
<html lang="en">
<head>
    <title>Senior Registration | SENIOR-CARE</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="userStyle.css">
</head>
<body>

<div class="navbar-custom">SENIOR-CARE MANAGEMENT SYSTEM</div>

<div class="container main-container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header">Senior Citizen Profiling Registration</div>
                <div class="card-body p-4">
                    
                    <form action="add_query_senior.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <!-- Basic Info -->
                            <div class="col-md-4">
                                <label class="fw-bold small">OscaIDNo. (PK)</label>
                                <input type="text" class="form-control" name="oscaID" required/>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small">Sex</label>
                                <select class="form-select" name="sex">
                                    <option>Male</option>
                                    <option>Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small">Status</label>
                                <select class="form-select" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Name Info -->
                            <div class="col-md-4"><label class="small">First Name</label><input type="text" class="form-control" name="fname" required/></div>
                            <div class="col-md-4"><label class="small">Middle Name</label><input type="text" class="form-control" name="mi"/></div>
                            <div class="col-md-4"><label class="small">Last Name</label><input type="text" class="form-control" name="lname" required/></div>

                            <!-- Address and Age -->
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="small">Purok</label>
                                        <select class="form-select" name="purok">
                                            <?php for($i=1; $i<=6; $i++) echo "<option value='Zone $i'>Zone $i</option>"; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="small">Barangay</label>
                                        <input type="text" class="form-control" name="brgy" value="Kalawag 1" readonly/>
                                    </div>
                                </div>
                            <div class="col-md-4">
                                <label class="small">Birthday</label>
                                <input type="date" class="form-control" name="bday" id="bdayInput" onchange="calculateAge()" required/>
                                <div id="ageDisplay" class="mt-1 text-primary fw-bold small">Derived Age: --</div>
                            </div>

                            <!-- Document Uploads -->
                            <div class="col-12 mt-4 border-top pt-3">
                                <label class="fw-bold text-success">1. PROFILE PICTURE (White Background)</label>
                                <input type="file" class="form-control" name="pic" required/>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="fw-bold text-success">2. THREE (3) SIGNATURES</label>
                                <input type="file" class="form-control mb-1" name="sig1" required/>
                                <input type="file" name="sig2" class="form-control mb-1" required/>
                                <input type="file" name="sig3" class="form-control" required/>
                                <div class="upload-instruction">Note: Sign on <strong>white paper</strong> then upload.</div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="fw-bold text-success">3. THREE (3) THUMBMARKS</label>
                                <input type="file" class="form-control mb-1" name="thumb1" required/>
                                <input type="file" name="thumb2" class="form-control mb-1" required/>
                                <input type="file" name="thumb3" class="form-control" required/>
                                <div class="upload-instruction">Note: Thumbmark on <strong>white paper</strong> then upload.</div>
                            </div>
                        </div>

                        <br />
                        <button type="submit" name="save" class="btn btn-forest w-100 py-3">SUBMIT & GENERATE QR</button>
                    </form>

                </div>
                <div class="card-footer bg-white text-center border-0 pb-4">
                    <p class="mb-0 text-muted small">Already have a profile? <a href="login.php" class="text-success fw-bold text-decoration-none">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="UserQRGenerate.js"></script>
</body>
</html>