<?php 
include("../includes/config.php"); 
include_once("include/header.php");

$doctor_id = $_GET['id'] ?? null;
if ($doctor_id) {
    $doctor_id = mysqli_real_escape_string($con, $doctor_id);
    $query = "SELECT * FROM doctors WHERE id = '$doctor_id' AND del_i = 0";
    $result = mysqli_query($con, $query);
    $doctors = mysqli_fetch_assoc($result);
}
?>
<!doctype html>
<html lang="en">
<title>Edit Doctor | Scans World</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="Scans World"/>
<meta name="author" content="Scans World" />
<link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
<link rel="stylesheet" href="assets/css/plugins/dropzone.min.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css" rel="stylesheet" />
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
  <div class="loader-track"><div class="loader-fill"></div></div>
</div>

<?php include("include/sidebar.php"); ?>

<div class="pc-container">
  <div class="pc-content">
    <div class="page-header">
      <div class="page-block">
        <div class="row align-items-center">
          <div class="col-md-12">
            <div class="page-header-title">
              <h2 class="mb-0">Edit Doctor</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ====================== EDIT DOCTOR FORM ====================== -->
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="container">
              <form method="POST" action="update_doctor.php" enctype="multipart/form-data">
                <div class="row g-3">

                  <!-- Doctor Name -->
                  <div class="col-md-4">
                    <label class="form-label">Doctor Name</label>
                    <input type="hidden" name="id" value="<?php echo $doctors['id']; ?>">
                    <input type="text" name="doctor_name" value="<?php echo htmlspecialchars($doctors['doctor_name']); ?>" class="form-control" placeholder="Doctor Name" required>
                  </div>

                  <!-- Doctor Image -->
                  <div class="col-md-4">
                    <label class="form-label">Doctor Image</label>
                    <input type="file" name="doctor_photo" accept=".png, .webp" class="form-control">
                    <input type="hidden" name="old" value="<?php echo $doctors['doctor_image']; ?>">
                    <?php if (!empty($doctors['doctor_image'])) { ?>
                      <img src="../uploads/doctor_images/<?php echo htmlspecialchars($doctors['doctor_image']); ?>" width="100" class="mt-2">
                    <?php } ?>
                  </div>

                  <!-- Image Title -->
                  <div class="col-md-4">
                    <label class="form-label">Image Title</label>
                    <input type="text" name="image_title" value="<?php echo htmlspecialchars($doctors['image_title']); ?>" class="form-control" placeholder="Image Title" required>
                  </div>

                  <!-- Image Alt Tag -->
                  <div class="col-md-4">
                    <label class="form-label">Image Alt Tag</label>
                    <input type="text" name="image_alttag" value="<?php echo htmlspecialchars($doctors['image_alttag']); ?>" class="form-control" placeholder="Image Alt Tag" required>
                  </div>

                  <!-- Doctor Studies -->
                  <div class="col-md-4">
                    <label class="form-label">Studies</label>
                    <input type="text" name="doctor_studies" value="<?php echo htmlspecialchars($doctors['doctor_studies']); ?>" class="form-control" placeholder="Studies" required>
                  </div>

                  <!-- Status -->
                  <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                      <option value="1" <?php echo ($doctors['status'] == '1') ? 'selected' : ''; ?>>Active</option>
                      <option value="0" <?php echo ($doctors['status'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                  </div>

                  <!-- Doctor Content -->
                  <div class="col-md-12">
                    <label class="form-label">Content</label>
                    <textarea class="form-control" id="editor-content" name="doctor_content" rows="5" placeholder="Content"><?php echo htmlspecialchars($doctors['doctor_content']); ?></textarea>
                  </div>

                  <!-- User ID -->
                  <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">

                  <!-- Submit Button -->
                  <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- ============================================================= -->

  </div>
</div>

<?php include("include/footer.php"); ?>

<script>
  ClassicEditor.create(document.querySelector('#editor-content')).catch(error => {
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
  layout_sidebar_change('light');
  change_box_container('false');
  layout_caption_change('true');
  layout_rtl_change('false');
  preset_change('preset-1');
</script>

</body>
</html>
