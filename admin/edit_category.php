<?php 
 include("../includes/config.php"); 
 include_once("include/header.php");
 $categories_id = $_GET['id'] ?? null;
if ($categories_id) {
    $query = "SELECT * FROM categories WHERE id = '$categories_id'";
    $result = mysqli_query($con, $query);
    $category = mysqli_fetch_assoc($result);
}
?>
<!doctype html>
<html lang="en">
<title>Blog Category | Scans World</title>
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
                  <h2 class="mb-0">Edit category</h2>
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
                <form method="POST" action="update_category.php" enctype="multipart/form-data" style="padding-left: 285px;">
    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
    <input type="hidden" name="existing_image" value="<?php echo $category['category_image']; ?>">
    
    <div class="row align-items-center">
        <div class="col-md-5">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $category['name']; ?>" placeholder="Enter Category Name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category Slug</label>
                <input type="text" name="slug" class="form-control" value="<?php echo $category['slug']; ?>" placeholder="Enter Slug" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Category Image</label>
                <input type="file" name="category_image" accept=".png, .webp" class="form-control">
                <img src="../uploads/blog/category_images/<?php echo $category['category_image']; ?>" alt="Centered Image" class="img-fluid mx-auto d-block" style="display: block; width: 100px;">
            </div>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $user_name; ?>">
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
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
    function validatename(input) {
    const regex = /^[A-Za-z\s]*$/; 
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
    if (!regex.test(input.value)) {
        input.setCustomValidity("Only letters and spaces are allowed");
    } else {
        input.setCustomValidity("");
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
