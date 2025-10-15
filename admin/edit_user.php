<?php 
 include("../includes/config.php");
 include_once("include/header.php"); 
 $userId = $_GET['id'] ?? null;
if ($userId) {
    $query = "SELECT * FROM admin WHERE id = '$userId'";
    $result = mysqli_query($con, $query);
    $user = mysqli_fetch_assoc($result);
}
?>
<!doctype html>
<html lang="en">
<title>User | Scans World</title>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Scans World"/>
    <meta name="author" content="Scans World" />
    <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/plugins/dropzone.min.css" />
    <link href="../../../../cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/plugins/quill.core.css" />
    <link rel="stylesheet" href="assets/css/plugins/quill.snow.css" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="assets/fonts/feather.css" />
    <link rel="stylesheet" href="assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/fonts/material.css" />
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="assets/css/style-preset.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
  <body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<?php include("include/sidebar.php") ?>
    <div class="pc-container">
      <div class="pc-content">
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                </ul>
              </div>
              <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Edit User</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-body">
        <div class="container">
          <form method="POST" action="edit_user_save.php" enctype="multipart/form-data" onsubmit="return validateForm()">
          <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>" />
            <div class="row">
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">User Name</label>
                  <input type="text" name="user_name" class="form-control" placeholder="User Name" value="<?php echo $user['user_name']; ?>" required />
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                <label>Email Id</label>
                <input type="email" name="emailid" id="emailid" class="form-control" placeholder="Email id" value="<?php echo $user['emailid']; ?>" required>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                <label>Mobile Number</label>
				<input type="text" name="phone" class="form-control" placeholder="Mobile Number" maxlength="10" value="<?php echo $user['phone']; ?>" required>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">New Password</label>
                  <div class="input-group">
                  <?php  $decoded_password = isset($user['password']) ? base64_decode($user['password']) : ''; ?>
                <input  id="password" type="password"  name="password" value="<?php echo htmlspecialchars($decoded_password); ?>" class="form-control"placeholder="Password" minlength="8" maxlength="10"pattern="^\S{8,10}$"  title="Password must be between 8 to 10 characters and must not contain spaces">
                    <div class="input-group-append">
                     <span class="input-group-text" onclick="togglePassword('password', this)">
                       <i class="fas fa-eye-slash"></i>
                          </span>
                       </div>
                      </div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                  <label>Confirm New Password</label>
                    <div class="input-group">
                    <?php  $decoded_password = isset($user['password']) ? base64_decode($user['password']) : ''; ?>
                   <input id="confirmpwd" type="password" name="confirmpwd" value="<?php echo htmlspecialchars($decoded_password); ?>" minlength="8" maxlength="10"pattern="^\S{8,10}$"  class="form-control" placeholder="Confirm Password" minlength="8" maxlength="10">
                      <div class="input-group-append">
                        <span class="input-group-text" onclick="togglePassword('confirmpwd', this)">
                       <i class="fas fa-eye-slash"></i>
                       </span>
                  </div>
               </div>
              <span id="passwordError" style="color: red;"></span>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                <label for="gender">Branch </label>
                <select class="form-control" name="branch_id" required>
    <option value="0" <?php echo ($user['branch_id'] == 0) ? 'selected' : ''; ?>>All</option> <!-- Static "All" option -->
    <?php
    $sql1 = "SELECT * FROM branch WHERE del_i=0 ORDER BY id";
    $result1 = mysqli_query($con, $sql1);
    
    while ($row1 = mysqli_fetch_assoc($result1)) {
        $selected = ($user['branch_id'] == $row1['id']) ? 'selected' : '';
        echo "<option value='{$row1['id']}' $selected>{$row1['branch_name']}</option>";
    }
    ?>
</select>

                    </div>
                </div>
                </div>
                <div class="row">
                <div class="col-sm-4">
                    <div class="mb-3">
                    <label for="role">Role</label>
					<select class="form-control" name="role" required>
					<option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
					<option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
					</select>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                <label for="gender">Status</label>
				<select class="form-control" name="status" required>
                <option value="1" <?php echo $user['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?php echo $user['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>									
				</select>
                </div>
              </div>
              <div>
			  <input type="checkbox" name="dashboard" id="dashboard"  <?php echo ($user['dashboard'] == 1) ? 'checked' : ''; ?>>
			<label for="dashboard">Dashboard</label>
			<input type="checkbox" name="settings" id="settings" <?php echo ($user['settings'] == 1) ? 'checked' : ''; ?>>
			<label for="dashboard">Settings</label>
			<input type="checkbox" name="general" id="general" <?php echo ($user['general'] == 1) ? 'checked' : ''; ?>>
			<label for="dashboard">General</label>
			<input type="checkbox" name="seo_management" id="seo_management" <?php echo ($user['seo_management'] == 1) ? 'checked' : ''; ?>>
			<label for="dashboard">Seo Management</label>
			<input type="checkbox" name="reports" id="reports" <?php echo ($user['reports'] == 1) ? 'checked' : ''; ?>>
			<label for="dashboard">Reports</label>
				</div>		
            </div>
            <div class="text-end mt-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
      </div>
    </div>
<?php include("include/footer.php");?>
<script>
document.getElementById("emailid").addEventListener("input", function(event) {
this.value = this.value.toLowerCase();});
</script>
<script>
    function togglePassword(inputId, element) {
        const input = document.getElementById(inputId);
        const icon = element.querySelector('i');
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }
    function validateForm() {
    const password = document.getElementById("password").value;
    const confirmpwd = document.getElementById("confirmpwd").value;
    if (password !== confirmpwd) {
        document.getElementById("passwordError").textContent = "Passwords do not match.";
        return false;
    }
    return true;
}
function validateForm() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmpwd").value;

        if (password !== confirmPassword) {
            document.getElementById("passwordError").innerText = "Passwords  not matching!";
            return false;
        } else {
            document.getElementById("passwordError").innerText = ""; 
            return true; 
        }
    }
</script>
<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/pcoded.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
<script>
  layout_change('light');
</script>
<script>
  layout_sidebar_change('light');
</script>
<script>
  change_box_container('false');
</script>
<script>
  layout_caption_change('true');
</script>
<script>
  layout_rtl_change('false');
</script>
<script>
  preset_change('preset-1');
</script>
  </body>
</html>
