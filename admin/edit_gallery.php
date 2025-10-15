<?php 
include("../includes/config.php"); 
include_once("include/header.php");
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM gallery_management WHERE id = $id";
    $result = mysqli_query($con, $sql);
    $galleryItem = mysqli_fetch_assoc($result);

    if (!$galleryItem) {
        die("Error: Gallery item not found.");
    }
    $mediaType = htmlspecialchars($galleryItem['media_type']);
    $title = htmlspecialchars($galleryItem['title']);
    $video_title = htmlspecialchars($galleryItem['video_title']);
    $imageAlt = htmlspecialchars($galleryItem['image_alt']);
    $imageTitle = htmlspecialchars($galleryItem['image_title']);
    $image = htmlspecialchars($galleryItem['image']);
    $video = htmlspecialchars($galleryItem['video']);
} else {
    die("Error: Invalid ID.");
}
?>
<!doctype html>
<html lang="en">
<title>Gallery | Scans World</title>
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
              <h2 class="mb-0">Edit Gallery</h2>
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
              <form method="POST" action="update_gallery.php" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-sm-4">
                    <div class="mb-3">
                      <label class="form-label">Media Type</label>
                      <select class="form-control" disabled name="media_type" id="mediaType" required aria-label="Media Type" onchange="toggleFields()">
                      <option value="" disabled>Select Media Type</option>
                    <option value="image" <?= ($mediaType === 'image') ? 'selected' : ''; ?>>Image</option>
                    <option value="video" <?= ($mediaType === 'video') ? 'selected' : ''; ?>>Video</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Image fields section -->
                <div id="imageFields" style="<?= ($mediaType === 'image') ? 'display: block;' : 'display: none;' ?>">
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" value="<?= $title ?>" name="title" placeholder="Title">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Image Alt Tag</label>
                        <input type="text" class="form-control" value="<?= $imageAlt ?>" name="image_alt" placeholder="Image Alt Tag">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Image Title Tag</label>
                        <input type="text" class="form-control" value="<?= $imageTitle ?>" name="image_title" placeholder="Image Title Tag">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" id="imageUpload" aria-label="Upload Image" accept="image/png, image/webp">
                        <?php if ($image): ?>
                        <img src="../uploads/gallery/<?= $image ?>" alt="Current Image" style="width: 35%;">
                    <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Video fields section -->
                <div id="videoFields" style="<?= ($mediaType === 'video') ? 'display: block;' : 'display: none;' ?>">
                  <div class="row">
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Video Title</label>
                        <input type="text" class="form-control"  value="<?= $video_title ?>"  name="video_title" placeholder="Video Title">
                      </div>
                    </div>
                    <div class="col-sm-4">
                      <div class="mb-3">
                        <label class="form-label">Video URL</label>
                        <input type="text" class="form-control"  value="<?= $video ?>"  name="video" placeholder="Video URL">
                      </div>
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
<script>
  function toggleFields() {
    const mediaType = document.getElementById('mediaType').value;
    const imageFields = document.getElementById('imageFields');
    const videoFields = document.getElementById('videoFields');

    if (mediaType === 'image') {
      imageFields.style.display = 'block';
      videoFields.style.display = 'none';
      document.querySelector('input[name="image_alt"]').required = true;
      document.querySelector('input[name="image_title"]').required = true;
      document.querySelector('input[name="image"]').required = true;
      document.querySelector('input[name="video"]').required = false;
    } else if (mediaType === 'video') {
      imageFields.style.display = 'none';
      videoFields.style.display = 'block';
      document.querySelector('input[name="video"]').required = true;
      document.querySelector('input[name="image_alt"]').required = false;
      document.querySelector('input[name="image_title"]').required = false;
      document.querySelector('input[name="image"]').required = false;
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
  layout_sidebar_change('light');
  change_box_container('false');
  layout_caption_change('true');
  layout_rtl_change('false');
  preset_change('preset-1');
</script>
</body>
</html>
