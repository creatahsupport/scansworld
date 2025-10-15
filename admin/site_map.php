<?php 

include("../includes/config.php"); 
include_once("include/header.php");

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['txtFile'])) {
    $targetDir = "../"; // Target directory for upload
    $targetFile = $targetDir . "sitemap.xml"; // File will be saved as sitemap.xml
    $fileType = strtolower(pathinfo($_FILES['txtFile']['name'], PATHINFO_EXTENSION)); // Get file extension

    // Check if the uploaded file is XML
    if ($fileType == "xml") {
        // Check MIME type for further validation
        $mimeType = mime_content_type($_FILES['txtFile']['tmp_name']);
        if ($mimeType == "text/xml" || $mimeType == "application/xml") {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['txtFile']['tmp_name'], $targetFile)) {
                echo "<script>alert('The XML file has been uploaded and replaced successfully.');</script>";
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        } else {
            // Invalid MIME type
            echo "<script>alert('Invalid file type. Please ensure the file is a valid XML document.');</script>";
        }
    } else {
        // Invalid file extension
        echo "<script>alert('Invalid file type. Please upload an XML file.');</script>";
    }
}
?>
<!doctype html>
<html lang="en">
<title>sitemap | Scans World</title>
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
                  <h2 class="mb-0">Add sitemap</h2>
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
                  <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="mb-3">
                          <label class="form-label">Sitemap (XML file)</label>
                          <input type="file" class="form-control" name="txtFile" id="txtFile" aria-label="Upload XML File" accept=".xml">
                        </div>
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
