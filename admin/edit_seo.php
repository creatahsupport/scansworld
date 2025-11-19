<?php 
include("../includes/config.php"); 
include_once("include/header.php");
if (isset($_GET['id'])) {
    $seo_id = intval($_GET['id']);
    $sql = "SELECT * FROM seo_management WHERE id = $seo_id";
    $result = mysqli_query($con, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $seo = mysqli_fetch_assoc($result);
    } else {
        echo "No settings found for the provided ID.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}
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
            <ul class="breadcrumb"></ul>
          </div>
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0">Edit SEO</h2>
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
              <form method="POST" action="update_seo.php" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Page URL</label>
                    <input type="hidden" class="form-control" value="<?php echo $seo['id']; ?>" name="id">
                    <input type="text" class="form-control" value="<?php echo $seo['page_url']; ?>" name="page_url" required placeholder="Page URL">
                  </div>
                 
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" class="form-control" value="<?php echo $seo['meta_title']; ?>" name="meta_title" required placeholder="Meta Title">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Meta Description</label>
                    <input type="text" class="form-control" value="<?php echo $seo['meta_description']; ?>" name="meta_description" required placeholder="Meta Description">
                  </div>
                  
                 
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Publisher</label>
                    <input type="text" class="form-control" value="<?php echo $seo['publisher'] ?? ''; ?>" name="publisher" placeholder="Publisher">
                  </div>
                  
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Author</label>
                    <input type="text" class="form-control" value="<?php echo $seo['author']; ?>" name="author" placeholder="Author">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">OG Description</label>
                    <input type="text" class="form-control" value="<?php echo $seo['og_description']; ?>" name="og_description" placeholder="OG Description">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">OG Image</label>
                    <input type="file" class="form-control" name="og_image" accept="image/png, image/webp">
                    <?php if ($seo['og_image']): ?>
                      <div style="margin-top: 10px;">
                        <img src="../uploads/seo/<?php echo htmlspecialchars($seo['og_image']); ?>" alt="OG Image" style="display: block; width: 100px;">
                        <small>Current: <?php echo $seo['og_image']; ?></small>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">OG Locale</label>
                    <input type="text" class="form-control" value="<?php echo $seo['og_local']; ?>" name="og_local" placeholder="OG Locale">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">OG Image Alt Tag</label>
                    <input type="text" class="form-control" name="og_alt_tag" value="<?php echo $seo['og_alt_tag']; ?>" placeholder="Og Image Alt Tag">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">OG Title</label>
                    <input type="text" class="form-control" name="og_title" value="<?php echo $seo['og_title']; ?>" placeholder="OG Title">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">OG Type</label>
                    <input type="text" class="form-control" name="og_type" value="<?php echo $seo['og_type']; ?>" placeholder="OG Type">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Geo Position (Latitude, Longitude)</label>
                    <input type="text" class="form-control" name="og_position" value="<?php echo $seo['og_position']; ?>" placeholder="Latitude, Longitude">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Geo Place Name</label>
                    <input type="text" class="form-control" name="og_place_name" value="<?php echo $seo['og_place_name']; ?>" placeholder="Geo Place Name">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Geo Region</label>
                    <input type="text" class="form-control" name="og_region" value="<?php echo $seo['og_region']; ?>" placeholder="Geo Region">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Geo Country</label>
                    <input type="text" class="form-control" name="og_country" value="<?php echo $seo['og_country']; ?>" placeholder="Geo Country">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Geo Latitude</label>
                    <input type="text" class="form-control" name="og_latitude" value="<?php echo $seo['og_latitude']; ?>" placeholder="Geo Latitude">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Geo Postal Code</label>
                    <input type="text" class="form-control" name="og_postal_code" value="<?php echo $seo['og_postal_code']; ?>" placeholder="Geo Postal Code">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Geo Longitude</label>
                    <input type="text" class="form-control" name="og_langtitude" value="<?php echo $seo['og_langtitude']; ?>" placeholder="Geo Longitude">
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">ICBM</label>
                    <input type="text" class="form-control" name="icbm" value="<?php echo $seo['icbm']; ?>" placeholder="ICBM">
                  </div>
                
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Twitter Title</label>
                    <input type="text" class="form-control" value="<?php echo $seo['twitter_title'] ?? ''; ?>" name="twitter_title" placeholder="Twitter Title">
                  </div>
                 
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Twitter Image</label>
                    <input type="file" class="form-control" name="twitter_image" accept="image/png, image/webp">
                    <?php if (!empty($seo['twitter_image'])): ?>
                      <div style="margin-top: 10px;">
                        <img src="../uploads/seo/<?php echo htmlspecialchars($seo['twitter_image']); ?>" alt="Twitter Image" style="display: block; width: 100px;">
                        <small>Current: <?php echo $seo['twitter_image']; ?></small>
                      </div>
                    <?php endif; ?>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Twitter Site</label>
                    <input type="text" class="form-control" value="<?php echo $seo['twitter_site'] ?? ''; ?>" name="twitter_site" placeholder="Twitter Site">
                  </div>
                   <div class="col-sm-4 mb-3">
                    <label class="form-label">Twitter Description</label>
                    <textarea class="form-control" name="twitter_description" placeholder="Twitter Description"><?php echo $seo['twitter_description'] ?? ''; ?></textarea>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Scheme</label>
                    <textarea class="form-control" name="scheme" placeholder="Scheme"><?php echo $seo['scheme']; ?></textarea>
                  </div>
                  <div class="col-sm-4 mb-3">
                    <label class="form-label">Keywords</label>
                    <textarea class="form-control" name="keywords" placeholder="Keywords"><?php echo $seo['keywords']; ?></textarea>
                  </div>
                </div>
                <input type="hidden" name="user_id" value="<?php echo $user_name; ?>">
                <div class="text-end mt-4">
                  <button type="submit" class="btn btn-primary">Update SEO</button>
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
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
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