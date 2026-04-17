<!DOCTYPE html>
<?php include("../includes/db_connection.php"); ?>
<html lang="en">
<head>
    <title>Senior Enrollment | SENIOR-CARE</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/userStyle.css">
</head>
<body>

<div class="navbar-custom">SENIOR-CARE MANAGEMENT SYSTEM</div>

<div class="container main-container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
                <div class="card shadow border border-1 border-secondary">
                    <div class="card-body p-4">
                        <form id="seniorForm" action="add_query_senior.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="fw-bold small">OscaIDNo. (Primary Key)</label>
                                        <input type="text" class="form-control card shadow border border-1 border-dark" name="oscaID" 
                                       placeholder="Numbers only (e.g. 00123)" 
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')" required/>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small">Sex</label>
                                <select class="form-select card shadow border border-1 border-black" name="sex" required>
                                    <option value="" disabled selected>Select Sex</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="fw-bold small">Citizen Status</label>
                                <select class="form-select card shadow border border-1 border-black" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-4"><label class="small">First Name</label><input type="text" class="form-control card shadow border border-1 border-black" name="fname" required/></div>
                            <div class="col-md-4"><label class="small">Middle Name</label><input type="text" class="form-control card shadow border border-1 border-black" name="mi"/></div>
                            <div class="col-md-4"><label class="small">Last Name</label><input type="text" class="form-control card shadow border border-1 border-black" name="lname" required/></div>

                            <div class="col-md-4">
                                <label class="small">Purok (Zone)</label>
                                <select class="form-select card shadow border border-1 border-black" name="purok" required>
                                    <option value="" disabled selected>Select Zone</option>
                                    <?php for($i=1; $i<=6; $i++) echo "<option value='Zone $i'>Zone $i</option>"; ?>
                                </select>
                            </div>
                            <div class="col-md-4"><label class="small">Barangay</label><input type="text" class="form-control card shadow border border-1 border-black" name="brgy" value="Kalawag 1" readonly/></div>
                            <div class="col-md-4">
                                <label class="small">Birthday</label>
                                <input type="date" class="form-control card shadow border border-1 border-black" name="bday" id="bdayInput" onchange="calculateAge()" required/>
                                <div id="ageDisplay" class="mt-1 text-primary fw-bold small">Derived Age: --</div>
                            </div>

                            <div class="col-12 mt-4 border-top pt-3">
                                <label class="fw-bold text-success">1. OFFICIAL PROFILE PICTURE</label>
                                <input type="file" class="form-control card shadow border border-1 border-black" name="pic" accept="image/*" required/>
                                <div class="upload-instruction">Note: Picture must have a plain <strong>white background</strong>.</div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="fw-bold text-success">2. SIGNATURES</label>
                                <input type="file" class="form-control card shadow border border-1 border-black" name="sig1" required/>
                                <div class="upload-instruction">Note: Sign on <strong>white paper</strong>, take a picture and upload.</div>
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="fw-bold text-success">3. THREE (3) THUMBMARKS</label>
                                <input type="file" class="form-control card shadow border border-1 border-black mb-1" name="thumb1" required/>
                                <input type="file" class="form-control card shadow border border-1 border-black mb-1" name="thumb2" required/>
                                <input type="file" class="form-control card shadow border border-1 border-black" name="thumb3" required/>
                                <div class="upload-instruction">Note: Thumbmark on <strong>white paper</strong>, take a picture and upload.</div>
                            </div>
                        </div>

                        <br />
                        <!-- Changed button class to btn-forest for the correct color -->
                        <button type="button" onclick="initiateProfiling()" class="btn btn-forest w-100 py-3">SUBMIT & GENERATE QR</button>
                    </form>
                    </div>
                    <div class="card-footer bg-white text-center border-0 pb-4">
                    <p class="mb-0 text-muted small">Already have an account? <a href="login.php" class="text-success fw-bold text-decoration-none">Login here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="js/calculateAge.js"></script>
<script src="js/UserQRGenerate.js"></script>
<script>
    function initiateProfiling() {
        const form = document.getElementById('seniorForm');
        if(!form.checkValidity()) { form.reportValidity(); return; }
        Swal.fire({
            title: 'Confirm Enrollment?',
            text: "Make sure all 3 signatures and thumbmarks are clear.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1F4B2C',
            confirmButtonText: 'Yes, Submit'
        }).then((result) => { if (result.isConfirmed) form.submit(); });
    }
</script>
</body>
</html>