<?php 
include("../includes/db_connection.php");
require_once('includes/session.php'); 

if (!isset($_GET['id'])) { 
    header("Location: profiling.php"); 
    exit; 
}

$id = $_GET['id']; 

$query = mysqli_query($conn, "SELECT seniors.* 
                              FROM seniors 
                              WHERE seniors.OscaIDNo = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Record not found.'); window.location='profiling.php';</script>";
    exit;
}

// Simple age calculation from Birthday
$birthYear  = date("Y", strtotime($data['Birthday']));
$birthMonth = date("m", strtotime($data['Birthday']));
$birthDay   = date("d", strtotime($data['Birthday']));

$currentYear  = date("Y");
$currentMonth = date("m");
$currentDay   = date("d");

$age = $currentYear - $birthYear;
if ($currentMonth < $birthMonth) {
    $age = $age - 1;
} else if ($currentMonth == $birthMonth && $currentDay < $birthDay) {
    $age = $age - 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Citizen Profile | <?php echo $id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h2 class="fw-bold text-success"><i class="fa fa-address-card me-2"></i> Citizen Full Record</h2>
            <a href="profiling.php" class="btn btn-outline-dark"><i class="fa fa-arrow-left"></i> Back to Master List</a>
        </div>

        <div class="card shadow border-0" id="printArea">
            <div class="row g-0">
                <div class="col-md-4 bg-dark text-white text-center p-5 id-side">
                    <img src="../uploads/<?php echo $data['Picture']; ?>" class="display-pic rounded-circle shadow mb-4 border border-3 border-success" style="width:160px; height:160px; object-fit:cover;">
                    <h3 class="text-uppercase fw-bold"><?php echo $data['FirstName']; ?></h3>
                    <p class="small opacity-75 mb-4">OscaIDNo. <?php echo $data['OscaIDNo']; ?></p>
                    
                    <div class="bg-white p-3 rounded d-inline-block shadow-sm" style="min-width: 150px; min-height: 150px;">
                        <div id="qrcode-target"></div>
                    </div>
                </img>

                <div class="col-md-8 p-5 bg-white data-side">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-4">
                        <h4 class="fw-bold text-success">Personal Data</h4>
                        <?php $statusClass = ($data['CitizenStatus'] == 'inactive') ? 'bg-danger' : 'bg-success'; ?>
                        <span class="badge <?php echo $statusClass; ?> fs-6 text-uppercase"><?php echo $data['CitizenStatus']; ?></span>
                    </div>

                   <div class="row mb-4 g-3">
                        <div class="col-12">
                            <label class="label-tag text-muted small fw-bold">OscaIDNo. (Primary ID)</label>
                            <div class="data-box fs-5 fw-bold text-primary"><?php echo $data['OscaIDNo']; ?>
                        </div>
                    </div>
                        <div class="col-12">
                            <label class="label-tag text-muted small fw-bold">FULL LEGAL NAME</label>
                            <div class="data-box fs-5 fw-bold text-uppercase"><?php echo $data['LastName'].", ".$data['FirstName']." ".$data['MiddleName']; ?>
                        </div>
                    </div>
                        <div class="col-4">
                            <label class="label-tag text-muted small fw-bold">SEX</label>
                            <div class="data-box"><?php echo $data['Sex']; ?>
                        </div>
                    </div>
                        <div class="col-4">
                            <label class="label-tag text-muted small fw-bold">DERIVED AGE</label>
                            <div class="data-box text-success fw-bold"><?php echo $age; ?> Years Old</div>
                        </div>
                        <div class="col-4">
                            <label class="label-tag text-muted small fw-bold">BIRTHDAY</label>
                            <div class="data-box"><?php echo date("F d, Y", strtotime($data['Birthday'])); ?></div>
                        </div>
                        <div class="col-6">
                            <label class="label-tag text-muted small fw-bold">PUROK / ZONE</label>
                            <div class="data-box"><?php echo $data['Purok']; ?></div>
                        </div>
                        <div class="col-6">
                            <label class="label-tag text-muted small fw-bold">BARANGAY</label>
                            <div class="data-box"><?php echo $data['Barangay']; ?></div>
                        </div>
                    </div>

                    <div class="mt-5 no-print text-end">
                        <button onclick="printQRCodeOnly()" class="btn btn-outline-dark fw-bold px-4 py-2 me-2">
                            <i class="fa fa-qrcode me-2"></i> Print QR Only
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="imageViewerModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content bg-transparent border-0 shadow-none">
                    <div class="modal-body p-0 text-center">
                        <div class="position-relative d-inline-block">
                            <button type="button" class="btn-close custom-close-btn position-absolute top-0 end-0 m-3 shadow" data-bs-dismiss="modal" aria-label="Close"></button>
                            <img id="modalPreviewImage" src="" class="img-fluid rounded shadow-lg" style="max-height: 85vh; background: white; padding: 5px; border: 1px solid #ddd;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="js/scripts.js"></script>
    <!-- CORRECT LINK TO ADMIN JS -->
    <script src="js/UserQRGenerate.js"></script>
    
    <script>
        window.onload = function() {
            // Using the standardized function
            renderProfileQR("<?php echo $id; ?>");
        };

        function viewImage(imgElement) {
            document.getElementById('modalPreviewImage').src = imgElement.src;
            var myModal = new bootstrap.Modal(document.getElementById('imageViewerModal'));
            myModal.show();
        }

        function printQRCodeOnly() {
            const qrContainer = document.getElementById("qrcode-target");
            const qrContent = qrContainer.innerHTML;

            if (!qrContent || qrContent.trim() === "") {
                alert("QR Code is still generating. Please wait.");
                return;
            }

            const newWindow = window.open("", "", "width=800,height=800");
            newWindow.document.write(`
                <html>
                <head>
                    <title>Print QR</title>
                    <style>
                        body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; }
                        #qr-wrapper { text-align: center; }
                        img, canvas { display: block; margin: 0 auto; }
                    </style>
                </head>
                <body>
                    <div id="qr-wrapper">${qrContent}</div>
                    <script>
                        window.onload = function() {
                            setTimeout(function() { window.print(); window.close(); }, 500);
                        };
                    <\/script>
                </body>
                </html>
            `);
            newWindow.document.close();
        }
    </script>
</body>
</html>