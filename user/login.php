<?php
include("../includes/db_connection.php");

// Fetch the Admin Contact Number to display on the screen
$q_admin = mysqli_query($conn, "SELECT ContactNumber FROM admin_users WHERE AdminID=1");
$row_admin = mysqli_fetch_array($q_admin);
$admin_contact = $row_admin['ContactNumber'];

// Handle Login Button Click
if (isset($_POST['login_btn'])) {
    $id = $_POST['login_osca'];
    $res = mysqli_query($conn, "SELECT OscaIDNo FROM seniors WHERE OscaIDNo = '$id'");
    $row = mysqli_fetch_array($res);

    if ($row) {
        header("Location: profile.php?id=$id");
        exit;
    } else {
        echo "<script>alert('Error: OscaIDNo. $id not found in our records.'); window.location='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/userStyle.css">
</head>
<body>

    <!-- Top Navigation Bar -->
    <div class="navbar-custom d-flex flex-column text-center" style="height: auto; padding: 15px 0;">
        <div>SENIOR-CARE MANAGEMENT SYSTEM</div>
        <div style="font-size: 0.85rem; font-weight: normal; margin-top: 5px; opacity: 0.9;">
            Admin Contact: <?php echo $admin_contact; ?>
        </div>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                
                <div class="card p-4 shadow">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold" style="color: var(--forest-deep);">Senior Citizen Login</h4>
                        <p class="text-muted small">Enter your ID to view your profile and QR code.</p>
                    </div>

                    <form action="login.php" method="POST">
                        <div class="mb-4">
                            <label class="fw-bold small mb-2">OscaIDNo.</label>
                            <input type="text" name="login_osca" class="form-control form-control-lg" placeholder="Digits only (e.g. 001)" required>
                        </div>

                        <button type="submit" name="login_btn" class="btn btn-forest w-100 py-2 mb-3">
                            VIEW PROFILE & QR
                        </button>

                    </form>
                    
                    <div class="text-center mt-3 pt-3 border-top">
                        <p class="small text-muted mb-2">To access your QR history and transaction records, enter your OscaIDNo.</p>
                        <a href="../index.php" class="btn btn-outline-dark btn-sm w-100 py-2 shadow-sm">
                            <i class="fa-solid fa-house me-2"></i> BACK TO MAIN PAGE
                        </a>
                    </div>
                </div>

                <div class="text-center mt-4 opacity-50">
                    <small>Barangay Kalawag 1 Management System</small>
                </div>

            </div>
        </div>
    </div>

</body>
</html>