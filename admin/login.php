<?php
session_start();
include("../includes/db_connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_osca = mysqli_real_escape_string($conn, $_POST['admin_osca']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = mysqli_query($conn, "SELECT * FROM admin_users WHERE AdminOscaID='$admin_osca' AND Password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $admin = mysqli_fetch_assoc($query);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_osca'] = $admin['AdminOscaID'];
        $_SESSION['admin_id'] = $admin['AdminID'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid Admin OscaID or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | SENIOR-CARE</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome (For the Eye Icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .btn-forest { background-color: #1F4B2C; color: white; font-weight: bold; }
        .btn-forest:hover { background-color: #4D7111; color: #C3E956; }
        .text-forest { color: #1F4B2C; }
        
        /* Make the eye icon look clickable */
        #eye-box { cursor: pointer; } 
    </style>
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow-lg p-4 border-0 rounded-4" style="width: 380px;">
        <h4 class="text-center text-forest mb-4 fw-bold">ADMIN PANEL</h4>
        
        <?php if(isset($error)) echo "<div class='alert alert-danger py-2 small fw-bold text-center'>$error</div>"; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="small fw-bold text-muted">Admin OscaID No.</label>
                <input type="text" name="admin_osca" class="form-control" 
                       placeholder="Digits only (e.g. 001)" 
                       oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
            </div>
            
            <div class="mb-4">
                <label class="small fw-bold text-muted">Password</label>
                <!-- Bootstrap Input Group (Puts the box and icon together) -->
                <div class="input-group">
                    <input type="password" name="password" id="passwordBox" class="form-control" placeholder="••••••••" required>
                    <span class="input-group-text" id="eye-box" onclick="togglePassword()">
                        <i class="fa fa-eye" id="eye-icon"></i>
                    </span>
                </div>
                <!-- End Input Group -->

                <div class="text-end mt-1">
                    <a href="forgot_password.php" class="small text-danger text-decoration-none">Forgot Password?</a>
                </div>
            </div>

            <button type="submit" class="btn btn-forest w-100 py-2">SECURE LOGIN</button>
        </form>
    </div>

    <!-- SIMPLE JAVASCRIPT -->
    <script>
        function togglePassword() {
            // 1. Grab the password box and the icon
            var passBox = document.getElementById("passwordBox");
            var eyeIcon = document.getElementById("eye-icon");

            // 2. Check: Is it hidden right now?
            if (passBox.type === "password") {
                // Change it to normal text so you can see it
                passBox.type = "text";
                // Change the icon to an eye with a slash
                eyeIcon.className = "fa fa-eye-slash text-danger"; 
            } else {
                // Change it back to hidden dots
                passBox.type = "password";
                // Change the icon back to a normal eye
                eyeIcon.className = "fa fa-eye text-dark"; 
            }
        }
    </script>
</body>
</html>