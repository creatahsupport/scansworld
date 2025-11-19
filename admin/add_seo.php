<?php 

 include("../includes/config.php"); 
 include_once("include/header.php");
?>
<!doctype html>
<html lang="en">
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
              <h2 class="mb-0">Add SEO</h2>
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
             <form method="POST" action="seo_save.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-sm-4 mb-3">
            <label class="form-label">Page URL</label>
            <input type="text" class="form-control" name="page_url" required placeholder="Page URL">
        </div>
       
        <div class="col-sm-4 mb-3">
            <label class="form-label">Meta Title</label>
            <input type="text" class="form-control" name="meta_title"  placeholder="Meta Title">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Meta Description</label>
            <input type="text" class="form-control" name="meta_description"  placeholder="Meta Description">
        </div>
        
       
        <div class="col-sm-4 mb-3">
            <label class="form-label">Publisher</label>
            <input type="text" class="form-control" name="publisher" placeholder="Publisher">
        </div>
       
        <div class="col-sm-4 mb-3">
            <label class="form-label">Author</label>
            <input type="text" class="form-control" name="author"  placeholder="Author">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">OG Description</label>
            <input type="text" class="form-control" name="og_description"  placeholder="OG Description">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">OG Image</label>
            <input type="file"  class="form-control" name="og_image" accept="image/png, image/webp">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">OG Locale</label>
            <input type="text" class="form-control" name="og_local" placeholder="OG Locale">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">OG Image Alt Tag</label>
            <input type="text" class="form-control" name="og_alt_tag"  placeholder="Og Image Alt Tag">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">OG Title</label>
            <input type="text" class="form-control" name="og_title"  placeholder="OG Title">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">OG Type</label>
            <input type="text" class="form-control" name="og_type"  placeholder="OG Type">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Geo Position (Latitude, Longitude)</label>
            <input type="text" class="form-control"  name="og_position" placeholder="Latitude, Longitude">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Geo Place Name</label>
            <input type="text" class="form-control"  name="og_place_name" placeholder="Geo Place Name">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Geo Region</label>
            <input type="text" class="form-control"  name="og_region" placeholder="Geo Region">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Geo Country</label>
            <input type="text" class="form-control"  name="og_country" placeholder="Geo Country">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Geo Latitude</label>
            <input type="text" class="form-control"  name="og_latitude" placeholder="Geo Latitude">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Geo Postal Code</label>
            <input type="text" class="form-control"  name="og_postal_code" placeholder="Geo Postal Code">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Geo Longitude</label>
            <input type="text" class="form-control"  name="og_langtitude" placeholder="Geo Longitude">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">ICBM</label>
            <input type="text" class="form-control"  name="icbm" placeholder="ICBM">
        </div>
      
       
        <div class="col-sm-4 mb-3">
            <label class="form-label">Twitter Title</label>
            <input type="text" class="form-control" name="twitter_title" placeholder="Twitter Title">
        </div>
        
        <div class="col-sm-4 mb-3">
            <label class="form-label">Twitter Image</label>
            <input type="file" class="form-control" name="twitter_image" accept="image/png, image/webp">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Twitter Site</label>
            <input type="text" class="form-control" name="twitter_site" placeholder="Twitter Site">
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Twitter Description</label>
            <textarea class="form-control" name="twitter_description" placeholder="Twitter Description"></textarea>
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Scheme</label>
            <textarea class="form-control"  name="scheme" placeholder="Scheme"></textarea>
        </div>
        <div class="col-sm-4 mb-3">
            <label class="form-label">Keywords</label>
            <textarea class="form-control" name="keywords"  placeholder="Keywords"></textarea>
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

