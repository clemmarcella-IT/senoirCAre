<?php 
require_once('includes/session.php'); 

if(isset($_POST['update_admin'])) {
    $new_osca = mysqli_real_escape_string($conn, $_POST['admin_osca']);
    $new_pass = mysqli_real_escape_string($conn, $_POST['admin_pass']);
    
    mysqli_query($conn, "UPDATE admin_users SET AdminOscaID='$new_osca', Password='$new_pass' WHERE AdminID=1");
    $_SESSION['admin_osca'] = $new_osca;
    echo "<script>alert('Admin Credentials Updated!'); window.location='settings.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Settings | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../user/css/userStyle.css">
</head>
<body class="d-flex bg-light">
    <?php include('includes/sidebar.php'); ?>

    <div class="flex-grow-1 p-4">
        <h2 class="fw-bold" style="color: #1F4B2C;"><i class="fa fa-cog me-2"></i> System Settings</h2>
        <hr>
        <div class="card col-md-6 border-0 shadow-sm mt-4">
            <div class="card-header bg-dark text-white fw-bold py-3">Login Credentials Configuration</div>
            <div class="card-body p-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="label-tag">Update Admin OscaIDNo.</label>
                        <input type="text" name="admin_osca" class="form-control" value="<?php echo $_SESSION['admin_osca']; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                    </div>
                    <div class="mb-4">
                        <label class="label-tag">Update Admin Password</label>
                        <input type="text" name="admin_pass" class="form-control" placeholder="Enter new password" required>
                    </div>
                    <button type="submit" name="update_admin" class="btn btn-forest w-100">SAVE ALL UPDATES</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>