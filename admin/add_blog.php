<?php 
 include("../includes/config.php"); 
 include_once("include/header.php");
?>
<!doctype html>
<html lang="en">
<title>Blog | Scans World</title>
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
                  <h2 class="mb-0">Add Blog</h2>
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
        <form method="POST" action="insert_blog.php" enctype="multipart/form-data">
    <div class="row">
        <!-- Title -->
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required placeholder="Title" title="Title" aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>

        <!-- Slug -->
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="mb-3">
                <label class="form-label">Slug</label>
                <input type="text" class="form-control" name="slug" required placeholder="Slug url" title="Only alphanumerics and dashes are allowed" aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>

        <!-- Image -->
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="image" required accept="image/png, image/webp">
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Image Alt Tag -->
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="mb-3">
                <label class="form-label">Image Alt Tag</label>
                <input type="text" class="form-control" name="image_alt_tag" required placeholder="image tag" title="Only alphanumerics and dashes are allowed" aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>

        <!-- Image Title -->
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="mb-3">
                <label class="form-label">Image Title</label>
                <input type="text" class="form-control" name="image_title" required placeholder="image Title" title="Only alphanumerics and dashes are allowed" aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>

        <!-- Meta Title -->
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="mb-3">
                <label class="form-label">Meta Title</label>
                <input type="text" class="form-control" name="meta_title" required placeholder="Meta Title" title="Only alphanumerics and dashes are allowed" aria-label="Username" aria-describedby="basic-addon1">
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4">
    <div class="mb-3">
        <label class="form-label">Blog Category</label>
        <select class="form-control" name="category" required>
            <option value="" disabled selected>Select a Category</option>
            <?php
            include("../includes/config.php");

            $query = "SELECT id, name FROM categories where del_i=0";
            $result = $con->query($query);
            if ($result->num_rows > 0) {
                while ($category = $result->fetch_assoc()) {
                    echo "<option value='" . $category['id'] . "'>" . $category['name'] . "</option>";
                }
            } else {
                echo "<option value='' disabled>No categories available</option>";
            }
            $con->close();
            ?>
        </select>
    </div>
</div>
    </div>

    <div class="row">
        <!-- Description -->
        <div class="col-sm-12">
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea class="form-control" id="Description" required name="description" aria-label="Description"></textarea>
            </div>
        </div>

        <!-- Content -->
        <div class="col-sm-12">
            <div class="mb-3">
                <label class="form-label">Content</label>
                <textarea class="form-control" id="editor-content" name="content" aria-label="Content"></textarea>
            </div>
        </div>
    </div>

    <!-- Hidden User ID -->
    <input type="hidden" name="user_id" value="<?php echo $user_name; ?>">

    <!-- Submit Button -->
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
        ClassicEditor
            .create(document.querySelector('#editor-content'))
            .catch(error => {
                console.error(error);
            });
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
