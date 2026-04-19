<?php 
include("../includes/db_connection.php");
require_once('includes/session.php'); 

if (!isset($_GET['id'])) { 
    header("Location: profiling.php"); 
    exit; 
}

$id = $_GET['id']; 

$query = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Record not found.'); window.location='profiling.php';</script>";
    exit;
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
                    
                    <div class="bg-white p-3 rounded d-inline-block shadow-sm">
                        <div id="qrcode-target"></div>
                    </div>
                </div>

                <div class="col-md-8 p-5 bg-white data-side">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-4">
                        <h4 class="fw-bold text-success">Personal Data</h4>
                        <span class="badge bg-success fs-6 text-uppercase"><?php echo $data['CitizenStatus']; ?></span>
                    </div>

                    <div class="row mb-4 g-3">
                        <div class="col-12"><label class="label-tag text-muted small fw-bold">OscaIDNo. (Primary ID)</label><div class="data-box fs-5 fw-bold text-primary"><?php echo $data['OscaIDNo']; ?></div></div>
                        <div class="col-12"><label class="label-tag text-muted small fw-bold">FULL LEGAL NAME</label><div class="data-box fs-5 fw-bold text-uppercase"><?php echo $data['LastName'].", ".$data['FirstName']." ".$data['MiddleName']; ?></div></div>
                        <div class="col-4"><label class="label-tag text-muted small fw-bold">SEX</label><div class="data-box"><?php echo $data['Sex']; ?></div></div>
                        <div class="col-4"><label class="label-tag text-muted small fw-bold">DERIVED AGE</label><div class="data-box text-success fw-bold"><?php echo $data['Age']; ?> Years Old</div></div>
                        <div class="col-4"><label class="label-tag text-muted small fw-bold">BIRTHDAY</label><div class="data-box"><?php echo date("F d, Y", strtotime($data['Birthday'])); ?></div></div>
                        <div class="col-6"><label class="label-tag text-muted small fw-bold">PUROK / ZONE</label><div class="data-box"><?php echo $data['Purok']; ?></div></div>
                        <div class="col-6"><label class="label-tag text-muted small fw-bold">BARANGAY</label><div class="data-box"><?php echo $data['Barangay']; ?></div></div>
                        <div class="col-12"><label class="label-tag text-muted small fw-bold">REGISTRATION TIMESTAMP</label><div class="data-box small text-muted"><?php echo date("F d, Y h:i A", strtotime($data['GenerateDate'])); ?></div></div>
                    </div>

                    <h5 class="fw-bold border-bottom pb-2 mb-3 mt-5 text-success">Documentary Verifications</h5>
                    <div class="row g-3 text-center no-print">
                        <div class="col-6">
                            <label class="small text-muted fw-bold mb-2">SIGNATURE (Click to view)</label>
                            <div class="d-flex justify-content-center">
                                <img src="../uploads/<?php echo $data['SignaturePicture']; ?>" class="doc-img rounded" onclick="viewImage(this)">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted fw-bold mb-2">3 THUMBMARKS (Click to view)</label>
                            <div class="d-flex justify-content-center">
                                <img src="../uploads/<?php echo $data['thumbNailPicture1']; ?>" class="doc-img rounded" onclick="viewImage(this)">
                                <img src="../uploads/<?php echo $data['thumbNailPicture2']; ?>" class="doc-img rounded" onclick="viewImage(this)">
                                <img src="../uploads/<?php echo $data['thumbNailPicture3']; ?>" class="doc-img rounded" onclick="viewImage(this)">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 no-print text-end">
                        <button onclick="printQRCodeOnly()" class="btn btn-outline-dark fw-bold px-4 py-2 me-2">
                            <i class="fa fa-qrcode me-2"></i> Print QR Only
                        </button>
                        <button onclick="printCitizenRecord()" class="btn btn-success fw-bold px-4 py-2">
                            <i class="fa fa-print me-2"></i> Print Official Record
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

        function printCitizenRecord() {
            var content = document.getElementById("printArea").innerHTML;
            var newWindow = window.open("", "", "width=900,height=800");
            newWindow.document.write("<html><head><title>Senior Profile - <?php echo $id; ?></title>");
            newWindow.document.write('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">');
            newWindow.document.write('<link rel="stylesheet" href="css/style.css">');
            newWindow.document.write(`
                <style>
                    body { background: white !important; padding: 0 !important; margin: 0 !important; font-family: sans-serif; }
                    .card { border: 2px solid #333 !important; box-shadow: none !important; margin: 0 !important; }
                    .p-5 { padding: 15px !important; } .p-3 { padding: 10px !important; } .p-4 { padding: 12px !important; }
                    .mb-4, .mb-5 { margin-bottom: 10px !important; } .mt-5 { margin-top: 10px !important; } .mb-3 { margin-bottom: 5px !important; }
                    .id-side { background-color: #1F4B2C !important; color: white !important; padding: 20px !important; -webkit-print-color-adjust: exact; text-align: center; }
                    .display-pic { width: 130px !important; height: 130px !important; margin-bottom: 10px !important; }
                    .data-side { padding: 20px !important; }
                    .data-box { border-bottom: 1px solid #ddd !important; font-weight: bold; font-size: 0.95rem !important; }
                    .label-tag { font-size: 0.7rem !important; text-transform: uppercase; color: #666 !important; }
                    .doc-img { width: 120px !important; height: 80px !important; object-fit: cover; margin: 2px !important; }
                    .no-print, .btn, .breadcrumb, #sidebar-overlay { display: none !important; }
                    @media print { @page { size: auto; margin: 10mm; } }
                </style>
            `);
            newWindow.document.write("</head><body>");
            newWindow.document.write("<div class='text-center mb-2'><h2>BARANGAY KALAWAG 1</h2><p>Official Senior Citizen Profile</p></div>");
            newWindow.document.write('<div class="card">' + content + '</div>');
            newWindow.document.write("</body></html>");
            newWindow.document.close();
            newWindow.focus();
            setTimeout(function() { newWindow.print(); newWindow.close(); }, 800);
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