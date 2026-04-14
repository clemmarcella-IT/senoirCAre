<?php
session_start();
// 1. Sync Clocks
date_default_timezone_set('Asia/Manila'); 
include("../includes/db_connection.php");
mysqli_query($conn, "SET time_zone = '+08:00'");

$error = "";
$showOTPModal = false;
$tempID = "";
$displayCode = "";

// --- LOGIC A: Standard Login (ID + Password) ---
if (isset($_POST['login_btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['admin_osca']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $q = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminOscaID='$id' AND Password='$pass'");
    if (mysqli_num_rows($q) > 0) {
        $row = mysqli_fetch_assoc($q);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_osca'] = $row['AdminOscaID'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid OscaIDNo or Password.";
    }
}

// --- LOGIC B: Forgot Password (Step 1: Generate Handshake) ---
if (isset($_POST['forgot_req'])) {
    $id = mysqli_real_escape_string($conn, $_POST['osca_for_reset']);
    $q = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminOscaID='$id'");

    if (mysqli_num_rows($q) > 0) {
        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+10 minutes"));
        mysqli_query($conn, "UPDATE admin_users SET ResetCode='$otp', CodeExpiry='$expiry' WHERE AdminOscaID='$id'");
        
        $tempID = $id;
        $displayCode = $otp; 
        $showOTPModal = true; 
    } else {
        $error = "Admin ID $id not found.";
    }
}

// --- LOGIC C: Verify Handshake (Step 2: Direct Login) ---
if (isset($_POST['verify_otp_login'])) {
    $id = mysqli_real_escape_string($conn, $_POST['temp_id']);
    $code = mysqli_real_escape_string($conn, $_POST['otp_code']);

    $sql = "SELECT * FROM admin_users WHERE AdminOscaID='$id' AND ResetCode='$code' AND CodeExpiry >= '".date("Y-m-d H:i:s")."'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_osca'] = $row['AdminOscaID'];
        mysqli_query($conn, "UPDATE admin_users SET ResetCode=NULL, CodeExpiry=NULL WHERE AdminOscaID='$id'");
        header("Location: dashboard.php");
        exit(); 
    } else {
        $error = "Verification failed: Code is incorrect or has expired.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { background: linear-gradient(135deg, #F4FFFC 0%, #D6F1DF 100%); height: 100vh; display: flex; align-items: center; justify-content: center; margin: 0; }
        .login-card { width: 400px; border-radius: 20px; background: white; padding: 40px; box-shadow: 0 15px 35px rgba(31, 75, 44, 0.15); }
        .otp-display { background: #f8f9fa; border: 2px dashed #1F4B2C; color: #1F4B2C; font-size: 32px; letter-spacing: 10px; font-weight: 900; padding: 10px; border-radius: 10px; margin: 15px 0; text-align: center;}
        .input-group-text { cursor: pointer; background: white; border-left: none; }
        .input-group .form-control { border-right: none; }

        /* LOGIN BUTTON STYLE - Matches User Portal Design */
        .btn-forest {
            background-color: var(--forest-deep);
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all var(--transition-speed);
            cursor: pointer;
        }
        .btn-forest:hover {
            background-color: var(--olive-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(31, 75, 44, 0.3);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="color: #1F4B2C;">ADMIN PANEL</h3>
            <p class="text-muted small">Senior-Care Management Access</p>
        </div>

        <?php if($error): ?>
            <div class="alert alert-danger py-2 small fw-bold text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="small fw-bold text-muted mb-1">Admin OscaIDNo.</label>
                <input type="text" name="admin_osca" class="form-control" placeholder="Numbers only" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
            
            <div class="mb-3">
                <label class="small fw-bold text-muted mb-1">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passInput" class="form-control" placeholder="••••••••" required>
                    <span class="input-group-text" onclick="togglePassword('passInput', 'eyeIcon')">
                        <i id="eyeIcon" class="fa fa-eye text-muted"></i>
                    </span>
                </div>
                <div class="text-end mt-1">
                    <button type="button" onclick="forgotPopup()" class="btn btn-link text-danger small text-decoration-none fw-bold p-0">Forgot Password?</button>
                </div>
            </div>

            <button type="submit" name="login_btn" class="btn btn-forest w-100 py-2 mb-3">
    LOGIN TO DASHBOARD
</button>
        </form>
        <!-- Find the end of your login-card and add this before the last </div> -->
            <div class="text-center mt-3 pt-3 border-top">
                <p class="small text-muted mb-2">Are you a Senior Citizen?</p>
                <a href="../user/login.php" class="btn btn-outline-secondary btn-sm w-100 py-2 shadow-sm">
                    <i class="fa-solid fa-house-user me-2"></i> BACK TO USER PORTAL
                </a>
            </div>
    </div>

    <!-- Hidden form for popup data -->
    <form id="handshakeForm" method="POST" style="display:none;">
        <input type="hidden" name="verify_otp_login" value="1">
        <input type="hidden" name="temp_id" id="form_temp_id">
        <input type="hidden" name="otp_code" id="form_otp_code">
    </form>

    <script src="js/togglePassword.js"></script>
    <script>
        // Trigger Forgot Password ID Entry
        function forgotPopup() {
            Swal.fire({
                title: 'Request Security Code',
                text: 'Enter Admin OscaIDNo:',
                input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#1F4B2C',
                preConfirm: (id) => { if (!id) { Swal.showValidationMessage('ID is required'); } return id; }
            }).then((result) => {
                if (result.isConfirmed) {
                    var f = document.createElement('form'); f.method = 'POST';
                    f.innerHTML = `<input type="hidden" name="forgot_req" value="1"><input type="hidden" name="osca_for_reset" value="${result.value}">`;
                    document.body.appendChild(f); f.submit();
                }
            });
        }
    </script>

    <?php if ($showOTPModal): ?>
    <script>
        // Trigger Security Handshake Box
        Swal.fire({
            title: 'Security Handshake',
            html: `<div class="text-muted small">Generated Code for Demo:</div><div class="otp-display"><?php echo $displayCode; ?></div>`,
            input: 'text',
            inputAttributes: { maxlength: 6, autofocus: 'autofocus', style: 'text-align:center; font-size:24px; letter-spacing:5px;' },
            confirmButtonText: 'VERIFY & LOGIN',
            confirmButtonColor: '#1F4B2C',
            allowOutsideClick: false,
            preConfirm: (code) => { if (!code || code.length < 6) { Swal.showValidationMessage('Enter 6 digits'); } return code; }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form_temp_id').value = "<?php echo $tempID; ?>";
                document.getElementById('form_otp_code').value = result.value;
                document.getElementById('handshakeForm').submit();
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>