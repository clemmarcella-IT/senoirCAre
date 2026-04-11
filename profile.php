<?php
require_once('include.php');
$id = mysqli_real_escape_string($conn, $_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$id'");
$row = mysqli_fetch_assoc($res);
$age = (new DateTime($row['Birthday']))->diff(new DateTime('today'))->y;
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Profile - OscaIDNo. <?php echo $id; ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="userStyle.css"></head>
<body>
<div class="navbar-custom no-print"><i class="fa-solid fa-id-card me-2"></i> SENIOR-CARE PORTAL</div>
<div class="container py-4 main-container"><div class="row justify-content-center"><div class="col-xl-11">
    <div class="alert alert-warning text-center fw-bold no-print">🔒 OscaIDNo. <?php echo $id; ?> is a Verified Record. (Read-Only)</div>
    <div class="profile-card"><div class="row g-0">
        <div class="col-4 id-side">
            <img src="uploads/<?php echo $row['Picture']; ?>" class="display-pic shadow">
            <h5 class="fw-bold mb-0"><?php echo $row['FirstName']; ?></h5>
            <p class="small opacity-75 mb-3">OscaIDNo. <?php echo $id; ?></p>
            <div id="qrcode-target"></div>
            <div class="mt-4 px-2 no-print"><div class="p-2 rounded bg-white bg-opacity-10 small border border-light border-opacity-25">Screenshot this QR code</div></div>
        </div>
        <div class="col-8 data-side">
            <div class="d-flex justify-content-between mb-3"><span class="section-title">Official Registry Details</span><span class="badge bg-success py-2 px-3"><?php echo strtoupper($row['CitezenStatus']); ?></span></div>
            <div class="row">
                <div class="col-6"><label class="label-tag">OscaIDNo.</label><div class="data-box text-primary"><?php echo $id; ?></div></div>
                <div class="col-6"><label class="label-tag">Registration Date</label><div class="data-box"><?php echo date("M d, Y", strtotime($row['GenerateDate'])); ?></div></div>
                <div class="col-12"><label class="label-tag">Full Legal Name</label><div class="data-box"><?php echo $row['LastName'].", ".$row['FirstName']." ".$row['MiddleName']; ?></div></div>
                <div class="col-4"><label class="label-tag">Sex</label><div class="data-box"><?php echo $row['Sex']; ?></div></div>
                <div class="col-4"><label class="label-tag">Derived Age</label><div class="data-box"><?php echo $age; ?> Years</div></div>
                <div class="col-4"><label class="label-tag">Birthday</label><div class="data-box"><?php echo date("M d, Y", strtotime($row['Birthday'])); ?></div></div>
                <div class="col-12"><label class="label-tag">Address</label><div class="data-box"><?php echo $row['StreetAddress'].", ".$row['Purok'].", ".$row['Barangay']; ?></div></div>
            </div>
            <div class="mt-4 d-flex gap-2 no-print">
                <button onclick="window.print()" class="btn btn-forest flex-grow-1">PRINT PROFILE</button>
                <a href="login.php" class="btn btn-outline-secondary px-4">LOGOUT</a>
            </div>
        </div>
    </div></div>
</div></div></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="UserQRGenerate.js"></script>
<script>window.onload = function() { renderProfileQR("<?php echo $id; ?>"); };</script>
</body>
</html>