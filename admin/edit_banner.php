<?php 
include("../includes/config.php"); 
include_once("include/header.php");
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM banner WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $banner = mysqli_fetch_assoc($result);

    if (!$banner) {
        die("Error: Gallery item not found.");
    }
    $mediaType = htmlspecialchars($banner['image_type']);
    $imageAlt = htmlspecialchars($banner['image_alt']);
    $imageTitle = htmlspecialchars($banner['image_title']);
    $image = htmlspecialchars($banner['image']);
} else {
    die("Error: Invalid ID.");
}
?>
<!doctype html>
<html lang="en">
<title>Banner | Scans World</title>
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
              <h2 class="mb-0">Edit Banner</h2>
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
            <form method="POST" action="update_banner.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-4">
                <div class="mb-3">
    <label class="form-label">Image Type</label>
    <select class="form-control" name="image_type" id="mediaType" required aria-label="Media Type" disabled>
        <option value="" selected>Select Media Type</option>
        <option value="desktop" <?= ($mediaType === 'desktop') ? 'selected' : ''; ?>>Desktop</option>
        <option value="mobile" <?= ($mediaType === 'mobile') ? 'selected' : ''; ?>>Mobile</option>
    </select>
</div>

                </div>
                <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label">Image Alt Tag</label>
                    <input type="text" class="form-control" value="<?= $imageAlt ?>"  name="image_alt" required placeholder="Image Alt Tag">
                </div>
                </div>
                <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label">Image Title Tag</label>
                    <input type="text" class="form-control" value="<?= $imageTitle ?>"  name="image_title" required placeholder="Image Title Tag">
                </div>
                </div>
            </div>

            <div class="row">
            
                <div class="col-sm-4">
                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" class="form-control" name="image"  id="imageUpload" aria-label="Upload Image" accept="image/png, image/webp">
                    <?php if ($image): ?>
                        <img src="../uploads/banner/<?= $image ?>" alt="Current Image" style="width: 35%;">
                    <?php endif; ?>
                </div>
                </div>
            </div>
            <input type="hidden" class="form-control" name="id" value="<?= $id ?>">
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
  layout_sidebar_change('light');
  change_box_container('false');
  layout_caption_change('true');
  layout_rtl_change('false');
  preset_change('preset-1');
</script>
</body>
</html>
