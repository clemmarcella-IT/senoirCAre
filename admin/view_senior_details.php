<?php 
require_once('includes/session.php'); 

// Check if an ID was passed in the URL
if (!isset($_GET['id'])) { 
    header("Location: profiling.php"); 
    exit; 
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$id'");
$data = mysqli_fetch_assoc($query);

// If ID doesn't exist, go back
if(!$data) { 
    echo "<script>alert('Record not found.'); window.location='profiling.php';</script>"; 
    exit; 
}

// Calculate the Age to display
$bday = new DateTime($data['Birthday']);
$today = new DateTime('today');
$age = $bday->diff($today)->y;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Citizen Profile | <?php echo $id; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .doc-img { height: 80px; width: 30%; object-fit: cover; border: 1px solid #ccc; margin-right: 5px; }
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
                <!-- LEFT SIDE: Profile Image & QR -->
                <div class="col-md-4 bg-dark text-white text-center p-5">
                    <img src="../uploads/<?php echo $data['Picture']; ?>" class="img-fluid rounded-circle shadow mb-4 border border-3 border-success" style="width:200px; height:200px; object-fit:cover;">
                    <h3 class="text-uppercase fw-bold"><?php echo $data['FirstName']; ?></h3>
                    <p class="opacity-75 mb-4">OscaIDNo. <?php echo $data['OscaIDNo']; ?></p>
                    
                    <div class="bg-white p-3 rounded d-inline-block shadow-sm">
                        <div id="qrcode-target"></div>
                    </div>
                </div>

                <!-- RIGHT SIDE: Complete Information -->
                <div class="col-md-8 p-5 bg-white">
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-4">
                        <h4 class="fw-bold text-success">Personal Data</h4>
                        <span class="badge bg-success fs-6"><?php echo strtoupper($data['CitezenStatus']); ?></span>
                    </div>

                    <div class="row mb-4 g-3">
                        <div class="col-12"><label class="text-muted small fw-bold">FULL LEGAL NAME</label><div class="fs-5 fw-bold text-uppercase"><?php echo $data['LastName'].", ".$data['FirstName']." ".$data['MiddleName']; ?></div></div>
                        <div class="col-4"><label class="text-muted small fw-bold">SEX</label><div><?php echo $data['Sex']; ?></div></div>
                        <div class="col-4"><label class="text-muted small fw-bold">DERIVED AGE</label><div class="text-success fw-bold"><?php echo $age; ?> Years Old</div></div>
                        <div class="col-4"><label class="text-muted small fw-bold">BIRTHDAY</label><div><?php echo date("F d, Y", strtotime($data['Birthday'])); ?></div></div>
                        <div class="col-6"><label class="text-muted small fw-bold">PUROK / ZONE</label><div><?php echo $data['Purok']; ?></div></div>
                        <div class="col-6"><label class="text-muted small fw-bold">BARANGAY</label><div><?php echo $data['Barangay']; ?></div></div>
                        <div class="col-12"><label class="text-muted small fw-bold">REGISTRATION TIMESTAMP</label><div><?php echo date("F d, Y h:i A", strtotime($data['GenerateDate'])); ?></div></div>
                    </div>

                    <!-- SHOWING ALL UPLOADED PICTURES -->
                    <h5 class="fw-bold border-bottom pb-2 mb-3 mt-5 text-success">Documentary Verifications</h5>
                    <div class="row g-3 text-center">
                        <div class="col-6">
                            <label class="small text-muted fw-bold mb-2">3 SIGNATURES</label>
                            <div>
                                <img src="../uploads/<?php echo $data['SignaturePicture1']; ?>" class="doc-img rounded">
                                <img src="../uploads/<?php echo $data['SignaturePicture2']; ?>" class="doc-img rounded">
                                <img src="../uploads/<?php echo $data['SignaturePicture3']; ?>" class="doc-img rounded">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="small text-muted fw-bold mb-2">3 THUMBMARKS</label>
                            <div>
                                <img src="../uploads/<?php echo $data['thumbNailPicture1']; ?>" class="doc-img rounded">
                                <img src="../uploads/<?php echo $data['thumbNailPicture2']; ?>" class="doc-img rounded">
                                <img src="../uploads/<?php echo $data['thumbNailPicture3']; ?>" class="doc-img rounded">
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 no-print text-end">
                        <button onclick="window.print()" class="btn btn-success fw-bold"><i class="fa fa-print"></i> Print Official Record</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="js/scripts.js"></script>
    <script>
        // Generate the QR code for this specific senior
        new QRCode(document.getElementById("qrcode-target"), {
            text: "<?php echo $id; ?>", 
            width: 120, 
            height: 120, 
            colorDark : "#000000"
        });
    </script>
</body>
</html>