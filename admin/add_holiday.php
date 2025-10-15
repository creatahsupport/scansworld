<?php 
 include("../includes/config.php"); 
 include_once("include/header.php");
?>
<!doctype html>
<html lang="en">
<title>Holiday | Scans World</title>
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
                  <h2 class="mb-0">Add Holiday</h2>
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
        <form method="POST" action="insert_holiday.php" enctype="multipart/form-data" onsubmit="return validateForm()">
    <div class="row">
        <div class="col-sm-4">
            <div class="mb-3">
                <label class="form-label">Holiday Date</label>
                <input type="date" class="form-control" name="holiday" min="<?= date('Y-m-d') ?>" required placeholder="Place Holiday date">
            </div>          
        </div>
    </div>

    <!-- Start a new row for the checkboxes with inline display -->
    <strong>Branch </strong><br></br>
    <div class="row align-items-center">
    <!-- "All" checkbox at the beginning -->
    <div class="form-check col-auto">
        <input class="form-check-input" type="checkbox" id="checkall">
        <label class="form-check-label" for="checkall">All</label>
    </div>

    <?php
   

    $user_role = $_SESSION['role'];
    $user_name = $_SESSION['user_name'];

    if ($user_role == "admin") {
        // Admins can see all branches
        $query = "SELECT id, branch_name FROM branch WHERE status = '1' AND del_i = 0 ORDER BY id DESC";
    } else {
        // Non-admin users only see their assigned branch
        $query = "SELECT branch.id, branch.branch_name 
                  FROM branch 
                  JOIN admin ON FIND_IN_SET(branch.id, admin.branch_id) > 0
                  WHERE admin.user_name = '$user_name' 
                  AND admin.status = 1 
                  AND admin.del_i = 0 
                  AND branch.status = '1' 
                  AND branch.del_i = 0 
                  ORDER BY branch.id DESC";
    }

    $result = $con->query($query);

    while ($branch = $result->fetch_assoc()) { 
        ?>
        <div class="form-check col-auto">
            <input class="form-check-input locationlist" type="checkbox" name="city[]" id="CP<?= $branch['id'] ?>" value="<?= $branch['id'] ?>">
            <label class="form-check-label" for="CP<?= $branch['id'] ?>">
                <?= $branch['branch_name'] ?>
            </label>
        </div>
        <?php 
    } 
    ?>
</div>
<br>
    <strong>Appointment Time </strong><br></br>
    <div class="row align-items-center">
        <!-- "All" checkbox at the beginning -->
        <div class="form-check col-auto">
            <input class="form-check-input" type="checkbox" id="checkall1">
            <label class="form-check-label" for="checkall1">All</label>
        </div>

        <?php
        $count = 0;
        $csql = mysqli_query($con, "SELECT * FROM appoinment_time ORDER BY `id` ASC");
        
        while ($csql1 = mysqli_fetch_array($csql)) { 
            
            ?>
            <div class="form-check col-auto">
                <input class="form-check-input time" type="checkbox" name="time[]" id="CP<?= $csql1['id'] ?>" value="<?= $csql1['id'] ?>">
                <label class="form-check-label" for="CP<?= $csql1['id'] ?>">
                    <?= $csql1['time'] ?>
                </label>
            </div>
            <?php 
            $count++;
        } 
        ?>
    </div><br></br>
    <div class="col-sm-4">
            <div class="mb-3">
            <label for="Description">Description</label>
            <textarea class="form-control" id="Description" required name="description" aria-label="Description"></textarea>
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
    <script src="assets/js/plugins/simple-datatables.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(() => {
        $('#checkall').click(function () {
            $('.locationlist').prop('checked', this.checked);
        });
        $('.locationlist').click(function () {
            $('#checkall').prop('checked', $('.locationlist:checked').length === $('.locationlist').length);
        });
    });
</script>
<script>
    $(document).ready(() => {
        $('#checkall1').click(function () {
            $('.time').prop('checked', this.checked);
        });
        $('.time').click(function () {
            $('#checkall1').prop('checked', $('.time:checked').length === $('.time').length);
        });
    });
</script>
<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/pcoded.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
  </body>
</html>
