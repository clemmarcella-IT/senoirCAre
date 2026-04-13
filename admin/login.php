<?php
session_start();
// 1. FORCE PHP TIMEZONE
date_default_timezone_set('Asia/Manila'); 

include("../includes/db_connection.php");

// 2. FORCE DATABASE TIMEZONE (Crucial for NOW() to work correctly)
mysqli_query($conn, "SET time_zone = '+08:00'");

$error = "";
$showOTPModal = false;
$tempID = "";
$displayCode = "";

// --- LOGIC 1: Standard Login ---
if (isset($_POST['login_btn'])) {
    $id = mysqli_real_escape_string($conn, $_POST['admin_osca']);
    $pass = mysqli_real_escape_string($conn, $_POST['password']);

    $q = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminOscaID='$id' AND Password='$pass'");
    if (mysqli_num_rows($q) > 0) {
        $row = mysqli_fetch_assoc($q);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_osca'] = $row['AdminOscaID'];
        $_SESSION['admin_id'] = $row['AdminID'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid OscaIDNo or Password.";
    }
}

// --- LOGIC 2: Forgot Password (Step 1) ---
if (isset($_POST['forgot_req'])) {
    $id = mysqli_real_escape_string($conn, $_POST['osca_for_reset']);
    $q = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminOscaID='$id'");

    if (mysqli_num_rows($q) > 0) {
        $otp = rand(100000, 999999);
        // Expiry set to 15 minutes to be safe
        $expiry = date("Y-m-d H:i:s", strtotime("+15 minutes"));
        
        mysqli_query($conn, "UPDATE admin_users SET ResetCode='$otp', CodeExpiry='$expiry' WHERE AdminOscaID='$id'");
        
        $tempID = $id;
        $displayCode = $otp; 
        $showOTPModal = true; 
    } else {
        $error = "Admin ID $id not found.";
    }
}

// --- LOGIC 3: Verify Handshake (Step 2) ---
if (isset($_POST['verify_otp_login'])) {
    $id = mysqli_real_escape_string($conn, $_POST['temp_id']);
    $code = mysqli_real_escape_string($conn, $_POST['otp_code']);

    // Precise check: ID matches, Code matches, and Expiry is in the future
    $sql = "SELECT * FROM admin_users WHERE AdminOscaID='$id' AND ResetCode='$code' AND CodeExpiry >= '".date("Y-m-d H:i:s")."'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_osca'] = $row['AdminOscaID'];
        $_SESSION['admin_id'] = $row['AdminID'];
        
        // Clean up
        mysqli_query($conn, "UPDATE admin_users SET ResetCode=NULL, CodeExpiry=NULL WHERE AdminOscaID='$id'");
        
        header("Location: dashboard.php");
        exit(); 
    } else {
        // Debugging: If it fails, let's see if the code exists but expired
        $checkOnlyCode = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminOscaID='$id' AND ResetCode='$code'");
        if(mysqli_num_rows($checkOnlyCode) > 0) {
            $error = "Verification failed: The security code has expired.";
        } else {
            $error = "Verification failed: The security code is incorrect.";
        }
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
    <style>
        body { background: linear-gradient(135deg, #F4FFFC 0%, #D6F1DF 100%); height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 400px; border-radius: 20px; background: white; padding: 40px; box-shadow: 0 15px 35px rgba(31, 75, 44, 0.15); }
        .btn-forest { background: #1F4B2C; color: white; font-weight: 800; padding: 12px; border-radius: 10px; border: none; }
        .otp-display { background: #f8f9fa; border: 2px dashed #1F4B2C; color: #1F4B2C; font-size: 32px; letter-spacing: 10px; font-weight: 900; padding: 10px; border-radius: 10px; margin: 15px 0; text-align: center;}
    </style>
</head>
<body>

    <div class="login-card">
        <div class="text-center mb-4">
            <h3 class="fw-bold" style="color: #1F4B2C;">ADMIN PANEL</h3>
            <p class="text-muted small">Identity Verification</p>
        </div>

        <?php if($error): ?>
            <div class="alert alert-danger py-2 small fw-bold text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="small fw-bold text-muted mb-1">Admin OscaIDNo.</label>
                <input type="text" name="admin_osca" class="form-control" placeholder="Enter ID" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
            
            <div class="mb-3">
                <label class="small fw-bold text-muted mb-1">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="passInput" class="form-control" placeholder="••••••••">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePass()"><i class="fa fa-eye" id="eye-icon"></i></button>
                </div>
                <div class="text-end mt-1">
                    <button type="button" onclick="forgotPopup()" class="btn btn-link text-danger small text-decoration-none fw-bold p-0">Forgot Password?</button>
                </div>
            </div>

            <button type="submit" name="login_btn" class="btn btn-forest w-100">SECURE LOGIN</button>
        </form>
    </div>

    <!-- HIDDEN FORM -->
    <form id="handshakeForm" method="POST" style="display:none;">
        <input type="hidden" name="verify_otp_login" value="1">
        <input type="hidden" name="temp_id" id="form_temp_id">
        <input type="hidden" name="otp_code" id="form_otp_code">
    </form>

    <script>
        function togglePass() {
            const pass = document.getElementById('passInput');
            const icon = document.getElementById('eye-icon');
            if(pass.type === 'password'){ pass.type = 'text'; icon.className = 'fa fa-eye-slash'; }
            else { pass.type = 'password'; icon.className = 'fa fa-eye'; }
        }

        function forgotPopup() {
            Swal.fire({
                title: 'Password Recovery',
                text: 'Enter Admin OscaIDNo:',
                input: 'text',
                showCancelButton: true,
                confirmButtonColor: '#1F4B2C',
                confirmButtonText: 'Generate Code'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    var f = document.createElement('form');
                    f.method = 'POST';
                    f.innerHTML = `<input type="hidden" name="forgot_req" value="1"><input type="hidden" name="osca_for_reset" value="${result.value}">`;
                    document.body.appendChild(f);
                    f.submit();
                }
            });
        }
    </script>

    <?php if ($showOTPModal): ?>
    <script>
        Swal.fire({
            title: 'Security Handshake',
            html: `
                <div class="text-muted small">ID Verified. Your code is:</div>
                <div class="otp-display"><?php echo $displayCode; ?></div>
                <div class="text-muted small">Type this code to login:</div>
            `,
            input: 'text',
            inputAttributes: { maxlength: 6, autofocus: 'autofocus', style: 'text-align:center; font-size:24px; letter-spacing:5px;' },
            confirmButtonText: 'VERIFY & LOGIN',
            confirmButtonColor: '#1F4B2C',
            allowOutsideClick: false,
            preConfirm: (code) => {
                if (!code || code.length < 6) { Swal.showValidationMessage('Enter 6 digits'); }
                return code;
            }
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