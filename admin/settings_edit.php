<?php 
 include("../includes/config.php"); 
 include_once("include/header.php");
$sql = "SELECT * FROM settings LIMIT 1";
$result = mysqli_query($con, $sql);
$settings = mysqli_fetch_assoc($result);

if (!$settings) {
    echo "<script>
            alert('No settings found.');
            window.location.href = 'settings.php';
          </script>";
    exit;
}

?>
<!doctype html>
<html lang="en">
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
                  <h2 class="mb-0">Edit Settings</h2>
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
          <form method="POST" action="update_settings.php" enctype="multipart/form-data">
            <div class="row">
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">Website Name</label>
                  <input type="text" class="form-control" name="website_name" required value="<?php echo htmlspecialchars($settings['website_name']); ?>" placeholder="Website Name">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">Footer Text</label>
                  <input type="text" class="form-control" name="footer_text" required value="<?php echo htmlspecialchars($settings['footer_text']); ?>" placeholder="Footer Text">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">Support Phone</label>
                  <input type="text" class="form-control" name="support_phone" required value="<?php echo htmlspecialchars($settings['support_number']); ?>" placeholder="Support Phone">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">Favicon Logo</label>
                  <input type="file" class="form-control" name="favicon_logo" accept="image/png, image/webp">
                </div>
                <?php if ($settings['favicon_logo']): ?>
                  <div style="margin-bottom: 20px;">
                    <img src="<?php echo htmlspecialchars($settings['favicon_logo']); ?>" alt="Favicon Logo" style="display: block; width: 50px;">
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">Website Logo</label>
                  <input type="file" class="form-control" name="image" accept="image/png, image/webp">
                </div>
                <?php if ($settings['website_logo']): ?>
                  <div style="margin-bottom: 20px;">
                    <img src="<?php echo htmlspecialchars($settings['website_logo']); ?>" alt="Current Logo" style="display: block; width: 100px;">
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">Sidebar Logo</label>
                  <input type="file" class="form-control" name="sidebar_logo" accept="image/png, image/webp">
                </div>
                <?php if ($settings['sidebar_logo']): ?>
                  <div style="margin-bottom: 20px;">
                    <img src="<?php echo htmlspecialchars($settings['sidebar_logo']); ?>" alt="Sidebar Logo" style="display: block; width: 100px;">
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">Design and Develop</label>
                  <input type="text" class="form-control" name="design_develop" required value="<?php echo htmlspecialchars($settings['design_develop']); ?>" placeholder="Design and Develop">
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mb-3">
                  <label class="form-label">Support Email</label>
                  <input type="text" class="form-control" name="support_mail" required value="<?php echo htmlspecialchars($settings['support_mail']); ?>" placeholder="Support Mail">
                </div>
              </div>
            </div>
             <input type="hidden" name="user_id" value="<?php echo $user_name; ?>">
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
