<?php 
include("../includes/db_connection.php");
require_once('includes/session.php'); 

if (!isset($_GET['id'])) { 
    header("Location: profiling.php"); 
    exit; 
}

$id = $_GET['id']; 

// Query gamit ang bagong database attributes
$query = mysqli_query($conn, "SELECT * FROM seniors WHERE OscaIDNo = '$id'");
$data = mysqli_fetch_array($query);

if (!$data) {
    echo "<script>alert('Record not found.'); window.location='profiling.php';</script>";
    exit;
}

// Logic for Pensioner Status Display (In-adjust para sa $data variable)
if ($data['PensionerStatus'] == 'Pensioner' || $data['PensionerStatus'] == 'Yes') {
    $pension_text = "Pensioner";
    $pension_color = "text-success";
} else {
    $pension_text = "Non-Pensioner";
    $pension_color = "text-danger";
}

// Age calculation logic para sa initial load
$birthYear = date("Y", strtotime($data['Birthday']));
$currentYear = date("Y");
$php_age = $currentYear - $birthYear;
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
        <!-- NAVIGATION -->
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h2 class="fw-bold text-success"><i class="fa fa-id-card me-2"></i> Citizen Full Record</h2>
            <a href="profiling.php" class="btn btn-outline-dark fw-bold shadow-sm">
                <i class="fa fa-arrow-left me-2"></i> BACK TO MASTER LIST
            </a>
        </div>

        <!-- TWO-TONE PROFILE CARD -->
        <div class="card shadow border-0" id="printArea" style="border-radius: 20px; overflow: hidden;">
            <div class="row g-0">
                
                <!-- LEFT SIDE (DARK SIDE) -->
                <div class="col-md-4 bg-dark text-white text-center p-5 id-side">
                    <h3 class="text-uppercase fw-bold mb-1"><?php echo $data['FirstName']; ?></h3>
                    <p class="small opacity-75 mb-4">OscaIDNo. <?php echo $data['OscaIDNo']; ?></p>
                    
                    <!-- QR CODE -->
                    <div class="bg-white p-3 rounded d-inline-block shadow-sm mb-4">
                        <div id="qrcode-target"></div>
                    </div>

                    <div class="mt-2 no-print d-grid gap-2">
                        <button onclick="printQRCodeOnly()" class="btn btn-success fw-bold py-2">
                            <i class="fa fa-print me-2"></i> PRINT QR CARD
                        </button>
                    </div>
                </div>

                <!-- RIGHT SIDE (DATA SIDE) -->
                <div class="col-md-8 p-5 bg-white data-side">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                        <h4 class="fw-bold text-success m-0">Personal Registry Data</h4>
                        
                        <!-- CITIZEN STATUS -->
                        <?php $statusColor = ($data['CitizenStatus'] == 'Inactive') ? 'bg-danger' : 'bg-success'; ?>
                        <span class="badge <?php echo $statusColor; ?> fs-6 text-uppercase px-4 py-2" style="border-radius: 50px;">
                            <?php echo $data['CitizenStatus']; ?>
                        </span>
                    </div>

                   <div class="row g-4">
                        <div class="col-12">
                            <label class="label-tag text-muted small fw-bold">OSCA ID NO. (PRIMARY KEY)</label>
                            <div class="data-box fs-5 fw-bold text-primary"><?php echo $data['OscaIDNo']; ?></div>
                        </div>

                        <div class="col-12">
                            <label class="label-tag text-muted small fw-bold">FULL LEGAL NAME</label>
                            <div class="data-box fs-4 fw-bold text-uppercase">
                                <?php echo $data['LastName']; ?>, <?php echo $data['FirstName']; ?> <?php echo $data['MiddleName']; ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="label-tag text-muted small fw-bold">SEX</label>
                            <div class="data-box"><?php echo $data['Sex']; ?></div>
                        </div>

                        <!-- LIVE AGE -->
                        <div class="col-md-4">
                            <label class="label-tag text-muted small fw-bold">AGE</label>
                            <div id="ageDisplay" class="data-box text-success fw-bold"><?php echo $php_age; ?> Years Old</div>
                        </div>

                        <div class="col-md-4">
                            <label class="label-tag text-muted small fw-bold">BIRTHDAY</label>
                            <div class="data-box"><?php echo date("F d, Y", strtotime($data['Birthday'])); ?></div>
                            <input type="date" id="bdayInput" value="<?php echo $data['Birthday']; ?>" style="display:none;">
                        </div>

                        <div class="col-md-6">
                            <label class="label-tag text-muted small fw-bold">PUROK / ZONE</label>
                            <div class="data-box"><?php echo $data['Purok']; ?></div>
                        </div>

                        <div class="col-md-6">
                            <label class="label-tag text-muted small fw-bold">PENSIONER STATUS</label>
                            <!-- GINAMIT ANG IYONG PENSION LOGIC DITO -->
                            <div class="data-box fw-bold <?php echo $pension_color; ?>">
                                <?php echo $pension_text; ?>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="label-tag text-muted small fw-bold">BARANGAY / LOCATION</label>
                            <div class="data-box"><?php echo $data['Barangay']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="js/UserQRGenerate.js"></script>
    <script src="js/calculateAge.js"></script>
    
   <script>
    window.onload = function() {
        var id = "<?php echo $id; ?>";
        var target = document.getElementById("qrcode-target");
        new QRCode(target, { text: id, width: 200, height: 200, colorDark : "#1F4B2C", colorLight : "#ffffff", correctLevel : QRCode.CorrectLevel.H });
        
    };

    function printQRCodeOnly() {
        var qrContent = document.getElementById("qrcode-target").innerHTML;
        var newWindow = window.open("", "", "width=800,height=800");
        newWindow.document.write(`<html><head><title>Print QR</title><style>body { margin: 0; display: flex; justify-content: center; align-items: center; height: 100vh; flex-direction: column; } #qr-wrapper { text-align: center; } img, canvas { display: block; margin: 0 auto; } p { font-family: Arial; font-weight: bold; font-size: 24px; margin-top: 10px; }</style></head><body><div id="qr-wrapper">${qrContent}<p>OSCA ID: <?php echo $id; ?></p></div><script>window.onload = function() { window.print(); window.close(); };<\/script></body></html>`);
        newWindow.document.close();
    }
</script>
</body>
</html>