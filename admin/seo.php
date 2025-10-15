<?php
include("../includes/config.php"); 
include_once("include/header.php");
$sql = "SELECT  * FROM seo_management WHERE del_i=0 order by id desc";
$result = $con->query($sql);

?>
<!doctype html>
<html lang="en">
<head>
<title>SEO | Scans World</title>
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
                  <h2 class="mb-0">Seo List</h2>
                </div>
              </div>
              
            </div>
          </div>
        </div>
      

<div class="row">
    <div class="col-sm-12">
        <div class="card border-0 table-card user-profile-list">
            <div class="card-body">
            <a value="Add New" href= "add_seo.php" class="btn btn-primary btn-lg">Add New</a></div>
                <div class="table-responsive">
                    <table class="table table-hover" id="pc-dt-simple">
                        <thead>
                            <tr>
                          <th>Sno</th>
                          <th>Page Url</th>
                          <th>Meta Title</th>
                          <th>Meta Description</th>
                          <th>Created on</th>
                          <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          if ($result->num_rows > 0) {
                            $i = 0;   while ($row = $result->fetch_assoc()) {  $i++;
                          ?>
                              <tr>
                                  <td><?php echo $i; ?></td>
                                  <td><?php echo $row['page_url']; ?></td>
                                  <td><?php echo $row['meta_title']; ?></td>
                                  <td><?php echo $row['meta_description']; ?></td>
                                  <td><?= date("d-m-Y", strtotime($row['created_at'])) ?></td>
                                
                                  <td>
                                      <div class="d-flex">
                                          <a href="edit_seo.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm me-2">Edit</a>
                                          <form action="seo_delete.php" onsubmit="return validate(this);" method="post">
                                              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                              <input type="hidden" name="user_id" value="<?php echo $user_name; ?>">
                                              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                          </form>
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
