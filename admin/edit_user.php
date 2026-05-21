<?php
include("../includes/config.php");
include_once("include/header.php");
$userId = $_GET['id'] ?? null;
if ($userId) {
  $stmt = $con->prepare("SELECT * FROM admin WHERE id = ?");
  $stmt->bind_param("i", $userId);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>Edit User | Scans World</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Scans World" />
  <meta name="author" content="Scans World" />
  <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
  <link rel="stylesheet" href="assets/css/plugins/dropzone.min.css" />
  <link href="../../../../cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css"
    rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/plugins/quill.core.css" />
  <link rel="stylesheet" href="assets/css/plugins/quill.snow.css" />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="assets/fonts/phosphor/duotone/style.css" />
  <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" />
  <link rel="stylesheet" href="assets/fonts/feather.css" />
  <link rel="stylesheet" href="assets/fonts/fontawesome.css" />
  <link rel="stylesheet" href="assets/fonts/material.css" />
  <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
  <link rel="stylesheet" href="assets/css/style-preset.css" />
  <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
  data-pc-theme="light">
  <?php include("include/sidebar.php") ?>
  <div class="pc-container">
    <div class="pc-content">
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
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
                <form method="POST" action="edit_user_save.php" onsubmit="return validateForm()">
                  <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>" />
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" name="user_name" class="form-control"
                          value="<?php echo htmlspecialchars($user['user_name']); ?>" required />
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Email Id</label>
                        <input type="email" name="emailid" id="emailid" class="form-control"
                          value="<?php echo htmlspecialchars($user['emailid']); ?>" required>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Mobile Number</label>
                        <input type="text" name="phone" class="form-control" maxlength="10"
                          value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">New Password (leave blank to keep current)</label>
                        <div class="input-group">
                          <input id="password" type="password" name="password" class="form-control"
                            placeholder="New Password" minlength="8" maxlength="20">
                          <span class="input-group-text" onclick="togglePassword('password', this)"><i
                              class="fas fa-eye-slash"></i></span>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <div class="input-group">
                          <input id="confirmpwd" type="password" name="confirmpwd" class="form-control"
                            placeholder="Confirm New Password" minlength="8" maxlength="20">
                          <span class="input-group-text" onclick="togglePassword('confirmpwd', this)"><i
                              class="fas fa-eye-slash"></i></span>
                        </div>
                        <span id="passwordError" style="color: red;"></span>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Branch</label>
                        <select class="form-control" name="branch_id" required>
                          <option value="0" <?php echo ($user['branch_id'] == 0) ? 'selected' : ''; ?>>All</option>
                          <?php
                          $res = mysqli_query($con, "SELECT * FROM branch WHERE del_i=0 ORDER BY id");
                          while ($row = mysqli_fetch_assoc($res)) {
                            echo "<option value='{$row['id']}' " . ($user['branch_id'] == $row['id'] ? 'selected' : '') . ">{$row['branch_name']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-control" name="role" required>
                          <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                          <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-control" name="status" required>
                          <option value="1" <?php echo $user['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                          <option value="0" <?php echo $user['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-12">
                      <h6>Permissions</h6>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="dashboard" id="dashboard" <?php echo ($user['dashboard'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="dashboard">Dashboard</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="settings" id="settings" <?php echo ($user['settings'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="settings">Settings</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="general" id="general" <?php echo ($user['general'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="general">General</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="seo_management" id="seo_management" <?php echo ($user['seo_management'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="seo_management">SEO Management</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="reports" id="reports" <?php echo ($user['reports'] == 1) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="reports">Reports</label>
                      </div>
                    </div>
                  </div>
                  <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update User</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include("include/footer.php"); ?>
<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/pcoded.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
  <script>
    function togglePassword(inputId, element) {
      const input = document.getElementById(inputId);
      const icon = element.querySelector('i');
      input.type = input.type === "password" ? "text" : "password";
      icon.classList.toggle("fa-eye");
      icon.classList.toggle("fa-eye-slash");
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
  </script>
</body>

</html>