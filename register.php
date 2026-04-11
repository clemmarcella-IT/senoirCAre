<?php
require_once('include.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['oscaID']);
    $lName = mysqli_real_escape_string($conn, $_POST['lName']);
    $fName = mysqli_real_escape_string($conn, $_POST['fName']);
    $mName = mysqli_real_escape_string($conn, $_POST['mName']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $purok = mysqli_real_escape_string($conn, $_POST['purok']);
    $bday = mysqli_real_escape_string($conn, $_POST['bday']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if(!is_dir('uploads')) { mkdir('uploads', 0777, true); }

    $pic = $id . "_main.jpg"; move_uploaded_file($_FILES["pic"]["tmp_name"], "uploads/".$pic);
    $sigs = []; for($i=1;$i<=3;$i++) { $n=$id."_s$i.jpg"; move_uploaded_file($_FILES["sig$i"]["tmp_name"], "uploads/".$n); $sigs[$i]=$n; }
    $thms = []; for($i=1;$i<=3;$i++) { $n=$id."_t$i.jpg"; move_uploaded_file($_FILES["thumb$i"]["tmp_name"], "uploads/".$n); $thms[$i]=$n; }

    $sql = "INSERT INTO seniors (OscaIDNo, LastName, FirstName, MiddleName, Sex, StreetAddress, Purok, Barangay, Birthday, Picture, QRCode, CitezenStatus, SignaturePicture1, SignaturePicture2, SignaturePicture3, thumbNailPicture1, thumbNailPicture2, thumbNailPicture3, GenerateDate) 
            VALUES ('$id', '$lName', '$fName', '$mName', '$sex', '$street', '$purok', 'Kalawag 1', '$bday', '$pic', '$id', '$status', '{$sigs[1]}', '{$sigs[2]}', '{$sigs[3]}', '{$thms[1]}', '{$thms[2]}', '{$thms[3]}', NOW())";
    
    if(mysqli_query($conn, $sql)) { header("Location: profile.php?id=$id"); exit; }
}
?>
<!DOCTYPE html>
<html>
<head><title>Register | SENIOR-CARE</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="userStyle.css"></head>
<body>
    <div class="navbar-custom">SENIOR-CARE SYSTEM</div>
    <div class="container main-container"><div class="row justify-content-center"><div class="col-lg-10"><div class="card">
        <div class="card-header py-3">Senior Citizen Enrollment</div>
        <div class="card-body p-4">
            <form id="seniorForm" action="register.php" method="POST" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-4"><label class="fw-bold small">OscaIDNo. (PK)</label><input type="text" name="oscaID" class="form-control" required></div>
                    <div class="col-md-4"><label class="fw-bold small">Sex</label><select name="sex" class="form-select"><option>Male</option><option>Female</option></select></div>
                    <div class="col-md-4"><label class="fw-bold small">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
                    <div class="col-md-4"><input type="text" name="fName" class="form-control" placeholder="First Name" required></div>
                    <div class="col-md-4"><input type="text" name="mName" class="form-control" placeholder="Middle Name"></div>
                    <div class="col-md-4"><input type="text" name="lName" class="form-control" placeholder="Last Name" required></div>
                    <div class="col-md-12"><input type="text" name="street" class="form-control" placeholder="Street Address" required></div>
                    <div class="col-md-4"><select name="purok" class="form-select"><?php for($i=1;$i<=6;$i++) echo "<option value='Zone $i'>Zone $i</option>"; ?></select></div>
                    <div class="col-md-4"><input type="text" class="form-control" value="Kalawag 1" readonly></div>
                    <div class="col-md-4"><input type="date" name="bday" id="bdayInput" class="form-control" onchange="calculateAge()" required>
                    <div id="ageDisplay" class="small fw-bold text-primary mt-1">Derived Age: --</div></div>
                    <div class="col-12 mt-3 border-top pt-2"><label class="fw-bold text-success">1. PROFILE PICTURE</label><input type="file" name="pic" class="form-control" required><div class="upload-instruction">Note: <strong>White background</strong> required.</div></div>
                    <div class="col-md-6 mt-3"><label class="fw-bold text-success">2. THREE SIGNATURES</label><input type="file" name="sig1" class="form-control mb-1" required><input type="file" name="sig2" class="form-control mb-1" required><input type="file" name="sig3" class="form-control" required><div class="upload-instruction">Note: <strong>White paper</strong> signatures.</div></div>
                    <div class="col-md-6 mt-3"><label class="fw-bold text-success">3. THREE THUMBMARKS</label><input type="file" name="thumb1" class="form-control mb-1" required><input type="file" name="thumb2" class="form-control mb-1" required><input type="file" name="thumb3" class="form-control" required><div class="upload-instruction">Note: <strong>White paper</strong> thumbmarks.</div></div>
                </div>
                <button type="button" class="btn btn-forest w-100 mt-4 py-3" onclick="initiateProfiling()">SUBMIT & GENERATE QR</button>
            </form>
        </div>
        <div class="card-footer bg-white text-center border-0"><a href="login.php" class="text-success small fw-bold text-decoration-none">Already have an account? Login</a></div>
    </div></div></div></div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script><script src="UserQRGenerate.js"></script>
</body>
</html>