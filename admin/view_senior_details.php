<?php 
require_once('includes/session.php'); 

if (!isset($_GET['id'])) { header("Location: profiling.php"); exit; }

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$id'");
$data = mysqli_fetch_assoc($query);

if(!$data) { echo "<script>alert('Record not found.'); window.location='profiling.php';</script>"; exit; }

// Derived Age
$bday = new DateTime($data['Birthday']);
$today = new DateTime('today');
$age = $bday->diff($today)->y;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile - OscaIDNo. <?php echo $id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .doc-img { height: 75px; width: 30%; object-fit: cover; border: 1px solid #ccc; margin-right: 5px; border-radius: 5px; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body class="d-flex bg-light">
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content" class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h2 class="fw-bold text-success"><i class="fa fa-address-card me-2"></i> Citizen Full Record</h2>
            <a href="profiling.php" class="btn btn-outline-dark"><i class="fa fa-arrow-left"></i> Back to Master List</a>
        </div>

        <div class="card shadow border-0" id="printArea">
            <div class="row g-0">
                <!-- LEFT SIDE -->
                <div class="col-4 bg-dark text-white text-center p-4 id-side">
                    <img src="../uploads/<?php echo $data['Picture']; ?>" class="display-pic rounded-circle shadow mb-4 border border-3 border-success" style="width:140px; height:140px; object-fit:cover;">
                    <h4 class="text-uppercase fw-bold"><?php echo $data['FirstName']; ?></h4>
                    <p class="small opacity-75">OscaIDNo. <?php echo $data['OscaIDNo']; ?></p>
                    <div class="bg-white p-2 rounded d-inline-block shadow-sm">
                        <div id="qrcode-target"></div>
                    </div>
                    <div class="mt-4 no-print small opacity-50">Screenshot or Download QR</div>
                </div>

                <!-- RIGHT SIDE -->
                <div class="col-8 p-4 bg-white data-side">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                        <h5 class="fw-bold text-success m-0">Official Registry Details</h5>
                        <span class="badge bg-success"><?php echo strtoupper($data['CitezenStatus']); ?></span>
                    </div>

                    <div class="row g-2">
                        <div class="col-12"><label class="label-tag">OscaIDNo. (Primary ID)</label><div class="data-box fw-bold text-primary"><?php echo $data['OscaIDNo']; ?></div></div>
                        <div class="col-12"><label class="label-tag">Full Legal Name</label><div class="data-box text-uppercase fw-bold"><?php echo $data['LastName'].", ".$data['FirstName']." ".$data['MiddleName']; ?></div></div>
                        <div class="col-4"><label class="label-tag">Sex</label><div class="data-box"><?php echo $data['Sex']; ?></div></div>
                        <div class="col-4"><label class="label-tag">Age</label><div class="data-box text-success fw-bold"><?php echo $age; ?> Yrs</div></div>
                        <div class="col-4"><label class="label-tag">Birthday</label><div class="data-box"><?php echo date("M d, Y", strtotime($data['Birthday'])); ?></div></div>
                        <div class="col-6"><label class="label-tag">Address</label><div class="data-box"><?php echo $data['Purok'].", ".$data['Barangay']; ?></div></div>
                        <div class="col-6"><label class="label-tag">Generate Date</label><div class="data-box small"><?php echo date("M d, Y", strtotime($data['GenerateDate'])); ?></div></div>
                    </div>

                    <h6 class="fw-bold border-bottom pb-2 mb-3 mt-4 text-success">Documentary Verifications</h6>
                    <div class="row g-2 text-center">
                        <div class="col-6 border-end">
                            <label class="small text-muted fw-bold">Signatures</label>
                            <div class="d-flex justify-content-center mt-1">
                                <img src="../uploads/<?php echo $data['SignaturePicture1']; ?>" class="doc-img">
                                <img src="../uploads/<?php echo $data['SignaturePicture2']; ?>" class="doc-img">
                                <img src="../uploads/<?php echo $data['SignaturePicture3']; ?>" class="doc-img">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted fw-bold">Thumbmarks</label>
                            <div class="d-flex justify-content-center mt-1">
                                <img src="../uploads/<?php echo $data['thumbNailPicture1']; ?>" class="doc-img">
                                <img src="../uploads/<?php echo $data['thumbNailPicture2']; ?>" class="doc-img">
                                <img src="../uploads/<?php echo $data['thumbNailPicture3']; ?>" class="doc-img">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 no-print text-end">
                        <button onclick="printCitizenRecord()" class="btn btn-success fw-bold"><i class="fa fa-print"></i> Print Record</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="js/UserQRGenerate.js"></script>
    <script>
        window.onload = function() { renderProfileQR("<?php echo $id; ?>"); };

        function printCitizenRecord() {
            var content = document.getElementById("printArea").innerHTML;
            var newWindow = window.open("", "", "width=800,height=600");
            newWindow.document.write("<html><head><title>Senior Profile</title>");
            newWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">');
            newWindow.document.write('<link rel="stylesheet" href="css/style.css">');
            newWindow.document.write("<style>body{background:white!important;padding:20px;} .card{border:1px solid #000!important;box-shadow:none!important;} .no-print{display:none!important;} .data-box{border-bottom:1px solid #000!important;font-weight:bold;} .id-side{background:#1F4B2C!important;color:white!important;-webkit-print-color-adjust:exact;}</style></head><body>");
            newWindow.document.write("<div class='text-center mb-3'><h2>BARANGAY KALAWAG 1</h2><p>Official Senior Citizen Profile</p></div>");
            newWindow.document.write('<div class="card">' + content + '</div>');
            newWindow.document.write("</body></html>");
            newWindow.document.close();
            newWindow.focus();
            setTimeout(() => { newWindow.print(); newWindow.close(); }, 750);
        }
    </script>
</body>
</html>