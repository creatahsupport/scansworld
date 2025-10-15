<?php 
include("../includes/config.php"); 
$sql = "SELECT * FROM settings WHERE del_i = 0 ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $settings = mysqli_fetch_assoc($result);
    $favicon_logo = htmlspecialchars($settings['favicon_logo']);
    $website_logo = htmlspecialchars($settings['website_logo']);
} 

?>
<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="description"
      content="Scans World"
    />
    <meta name="author" content="phoenixcoded" />
    <link rel="shortcut icon" type="image/png" href="<?php echo $favicon_logo; ?>">
    <link rel="stylesheet" href="assets/css/plugins/jsvectormap.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="assets/fonts/feather.css" />
    <link rel="stylesheet" href="assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/fonts/material.css" />
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="assets/css/style-preset.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .logo img {
            max-width: 300px;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">

<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>

<div class="container">
    <!-- Logo section -->
   
    
    <!-- Login box -->
    <div class="login-box">
    <div class="logo">
    <img src="<?php echo $website_logo; ?>" alt="Logo">
    </div>
        <h2>Login</h2>
        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group" style="position: relative;">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" class="form-control" required>
    
    <!-- Eye icon button -->
    <button type="button" onclick="togglePasswordVisibility()" style="position: absolute; right: 10px; top: 35px; background: none; border: none; cursor: pointer;">
        <i id="toggle-icon" class="fas fa-eye-slash"></i>
    </button>
</div>

            <button type="submit" class="btn-primary">Login</button>
        </form>
    </div>
</div>

<?php include("include/footer.php");?>
    
<script src="assets/js/plugins/apexcharts.min.js"></script>
<script src="assets/js/plugins/jsvectormap.min.js"></script>
<script src="assets/js/plugins/world.js"></script>
<script src="assets/js/plugins/world-merc.js"></script>
<script src="assets/js/pages/dashboard-default.js"></script>
<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/pcoded.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var icon = document.getElementById("toggle-icon");
        
        // Toggle between password and text input type
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }
</script>
</body>
</html>
