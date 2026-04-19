<?php
session_start();
include("../includes/db_connection.php");
include("../includes/functions.php");

$step = 1;
$error = "";

// STEP 1: Request OTP Logic
if (isset($_POST['request_otp'])) {
    $admin_osca = $_POST['admin_osca'];
    
    $query = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminOscaID='$admin_osca' LIMIT 1");
    $admin = mysqli_fetch_array($query);
    
    if ($admin) {
        $phone = $admin['ContactNumber'];
        
        $otp = rand(100000, 999999);
        $expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        mysqli_query($conn, "UPDATE admin_users SET ResetCode='$otp', CodeExpiry='$expiry' WHERE AdminOscaID='$admin_osca'");

        sendOTP($phone, $otp);

        // Set session variables
        $_SESSION['reset_admin_id'] = $admin_osca;
        $step = 2;
    } else {
        $error = "Admin ID not found.";
    }
}

// STEP 2: Verify the Code
if (isset($_POST['verify_otp'])) {
    // FIX: Check if the session exists first
    if (!isset($_SESSION['reset_admin_id'])) {
        header("Location: forgot_password.php"); // Send back to start if memory is lost
        exit();
    }

    $user_code = $_POST['otp_code'];
    $admin_osca = $_SESSION['reset_admin_id'];

    $query = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminOscaID='$admin_osca' AND ResetCode='$user_code' AND CodeExpiry > NOW()");
    $row = mysqli_fetch_array($query);

    if ($row) {
        $step = 3;
    } else {
        $error = "Invalid or Expired OTP Code!";
        $step = 2;
    }
}

// STEP 3: Reset Password
if (isset($_POST['save_password'])) {
    if (!isset($_SESSION['reset_admin_id'])) {
        header("Location: forgot_password.php");
        exit();
    }

    $new_pass = $_POST['new_pass'];
    $admin_osca = $_SESSION['reset_admin_id'];

    mysqli_query($conn, "UPDATE admin_users SET Password='$new_pass', ResetCode=NULL, CodeExpiry=NULL WHERE AdminOscaID='$admin_osca'");
    
    // Clear sessions after success
    unset($_SESSION['reset_admin_id']);

    echo "<script>alert('Password Reset Success!'); window.location='login.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Recovery | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../user/css/userStyle.css">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow p-4 rounded-4" style="width: 380px;">
        <h4 class="text-center text-danger fw-bold mb-4">ADMIN RECOVERY</h4>
        
        <?php if($error != ""): ?>
            <div class="alert alert-danger py-1 small text-center"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($step == 1): ?>
            <p class="small text-muted text-center">Enter your Admin ID to receive an OTP.</p>
            <form method="POST">
                <input type="text" name="admin_osca" class="form-control mb-3" placeholder="Admin ID" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                <button type="submit" name="request_otp" class="btn btn-danger w-100 fw-bold">SEND OTP</button>
            </form>

        <?php elseif ($step == 2): ?>
            <div class="alert alert-warning small text-center">OTP sent. Check <b>otp_log.txt</b>.</div>
            <form method="POST">
                <input type="text" name="otp_code" class="form-control mb-3 text-center fs-3" placeholder="000000" maxlength="6" required>
                <button type="submit" name="verify_otp" class="btn btn-warning w-100 fw-bold">VERIFY CODE</button>
            </form>

        <?php elseif ($step == 3): ?>
            <form method="POST">
                <label class="small fw-bold text-muted">New Password</label>
                <input type="text" name="new_pass" class="form-control mb-3" placeholder="Enter New Password" required>
                <button type="submit" name="save_password" class="btn btn-success w-100 fw-bold">UPDATE PASSWORD</button>
            </form>
        <?php endif; ?>

        <div class="text-center mt-4 border-top pt-3">
            <a href="login.php" class="text-secondary small text-decoration-none">Back to Login</a>
        </div>
    </div>
</body>
</html>