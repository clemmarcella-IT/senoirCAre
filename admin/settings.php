<?php 
require_once('includes/session.php'); 

if(isset($_POST['update_admin'])) {
    $new_osca = $_POST['admin_osca'];
    $new_pass = $_POST['admin_pass'];
    
    // Hash the password before saving
    $hashedPassword = password_hash($new_pass, PASSWORD_DEFAULT);
    mysqli_query($conn, "UPDATE admin_users SET AdminOscaID='$new_osca', Password='$hashedPassword' WHERE AdminID=1");
    $_SESSION['admin_osca'] = $new_osca;
    echo "<script>alert('Admin Credentials Updated!'); window.location='settings.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Settings | SENIOR-CARE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="css/style.css?v=<?php echo time(); ?>" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
    <?php include('includes/header.php'); ?>
    <?php include('includes/sidebar.php'); ?>

    <main id="main-content">
        <h2 class="fw-bold mb-4" style="color: var(--forest-deep);">System Settings</h2>
        
        <div class="row justify-content-start">
            <div class="col-md-6 col-lg-5">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header py-3">
                        <i class="fa-solid fa-user-gear me-2"></i> Admin Login Configuration
                    </div>
                    <div class="card-body p-4">
                        <form method="POST">
                            <div class="mb-4">
                                <label class="label-tag">Update Admin OscaIDNo.</label>
                                <input type="text" name="admin_osca" class="form-control form-control-lg" 
                                       value="<?php echo $_SESSION['admin_osca']; ?>" 
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                <small class="text-muted">This is used for your two-step login.</small>
                            </div>
                            
                            <div class="mb-4">
                                <label class="label-tag">Update Admin Password</label>
                                <div class="input-group">
                                    <input type="password" name="admin_pass" id="settingsPass" class="form-control form-control-lg" placeholder="New Password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('settingsPass', 'setEye')">
                                        <i id="setEye" class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="alert alert-success border-0 small py-2 mb-4">
                                <i class="fa-solid fa-shield-check me-1"></i> 
                                Security is active. All updates take effect immediately.
                            </div>

                            <!-- NEW DESIGNED BUTTON -->
                            <button type="submit" name="update_admin" class="btn-save-custom">
                                <i class="fa-solid fa-floppy-disk"></i> SAVE ALL UPDATES
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/scripts.js"></script>
    <script src="js/togglePassword.js"></script>
</body>
</html>