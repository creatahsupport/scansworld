<?php

include("../includes/config.php"); 
include_once("include/header.php");
error_reporting(E_ALL);         // Report all types of errors
ini_set('display_errors', 1); // Display errors on the screen
$sql = "SELECT id, website_name, footer_text, support_mail, support_number FROM settings where del_i=0 order by id desc";
$result = $con->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
<title>Settings | Scans World</title>
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
  </head>
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
                <div class="page-header-title">
                  <h2 class="mb-0">Admin Settings</h2>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      

<div class="row">
    <div class="col-sm-12">
        <div class="card border-0 table-card user-profile-list">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Website Name</th>
                                <th>Footer Text</th>
                                <th>Support Email</th>
                                <th>Support Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                          ?>
                              <tr>
                                  <td><?php echo htmlspecialchars($row['id']); ?></td>
                                  <td><?php echo htmlspecialchars($row['website_name']); ?></td>
                                  <td><?php echo htmlspecialchars($row['footer_text']); ?></td>
                                  <td><?php echo htmlspecialchars($row['support_mail']); ?></td>
                                  <td><?php echo htmlspecialchars($row['support_number']); ?></td>
                                  <td>
                                      <div class="d-flex">
                                          <a href="settings_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm me-2">Edit</a>
                                      </div>
                                  </td>
                              </tr>
                          <?php
                              }
                          }
                          ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
        </div>
      </div>
    </div>
      </div>
    </div>
    <?php include("include/footer.php");?>
    <script src="assets/js/plugins/simple-datatables.js"></script>
    <script>
      const dataTable = new simpleDatatables.DataTable('#pc-dt-simple', {
        sortable: false,
        perPage: 5
      });
    </script>
     <script>
    function validate(form) {
            return confirm('Do you really want to Delete this Data?');
    }
    </script>
<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/pcoded.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
  </body>
</html>
