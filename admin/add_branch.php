<?php 
 include("../includes/config.php"); 
 include_once("include/header.php");
?>
<!doctype html>
<html lang="en">
<title>Branch | Scans World</title>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                  <h2 class="mb-0">Add Branch</h2>
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
        <form method="POST" action="insert_location.php" enctype="multipart/form-data" onsubmit="return validateForm()">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <div class="mb-3">
          <label for="editBranchName">Branch Name</label>
          <input type="text" class="form-control" required id="editBranchName" name="branch" placeholder="Enter Branch Name" oninput="validateBranchName(this)">
        </div>
      </div>
      <div class="col-md-4">
  <div class="mb-3">
    <label for="editFees">Fees</label>
    <input type="text" name="fees" id="editFees" class="form-control" placeholder="Enter Amount" required oninput="validateInteger(this)">
  </div>
</div>


      <div class="col-md-4">
        <div class="mb-3">
          <label for="editSmsNumber">SMS Number (Multiple Numbers use comma separator)</label>
          <input type="text" name="sms_number" id="editSmsNumber" class="form-control" placeholder="Enter 10-Digit SMS Number" required>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="mb-3">
          <label for="editToEmail">To Email (Multiple emails use comma separator)</label>
          <input type="text" class="form-control" id="editToEmail" name="to_email" placeholder="To Email" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="mb-3">
          <label for="editCcEmail">CC Email (Multiple emails use comma separator)</label>
          <input type="text" class="form-control" id="editCcEmail" name="cc_mail" placeholder="CC Email" required>
        </div>
      </div>
      <div class="col-md-4">
        <div class="mb-3">
          <label for="status">Status</label>
          <select id="status" name="status" class="form-control" required>
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">In Active</option>
          </select>
        </div>
      </div>
    </div>
    <div>
      <strong>Time</strong>
      <div class="row pl-3 mb-3">
        <div class="form-check col-md-2">
          <input class="form-check-input" type="checkbox" id="checkall1">
          <label class="form-check-label" for="checkall1">All</label>
        </div>

        <?php
        $csql = mysqli_query($con, "SELECT * FROM appoinment_time ORDER BY
            CASE
                WHEN SUBSTRING_INDEX(time, ' ', -1) = 'AM' THEN STR_TO_DATE(time, '%h:%i %p')
                ELSE STR_TO_DATE(time, '%h:%i %p') + INTERVAL 12 HOUR
            END ASC");
        while ($csql1 = mysqli_fetch_array($csql)) { ?>
          <div class="form-check col-md-2">
            <input class="form-check-input time" type="checkbox" name="time[]" id="CP<?= $csql1['id'] ?>" value="<?= $csql1['id'] ?>">
            <label class="form-check-label" for="CP<?= $csql1['id'] ?>">
              <?= $csql1['time'] ?>
            </label>
          </div>
        <?php } ?>
      </div>
    </div>
<input type="hidden" name="user_id" value="<?php echo $user_name;?>">
    <div class="text-end mt-4">
      <button type="submit" name="addlocation" class="btn btn-primary">Submit</button>
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
  function validateInteger(input) {
    // Remove any non-digit characters
    input.value = input.value.replace(/[^0-9]/g, '');
  }
</script>
<script>
    $(document).ready(() => {
        $('#checkall1').click(function () {
            
            $('.time').prop('checked', this.checked);
        });
        $('.time').click(function () {
            if (!this.checked) {
                $('#checkall1').prop('checked', false);
            }
        });
    });
    function validateBranchName(input) {
    const regex = /^[A-Za-z\s]*$/; 
    input.value = input.value.replace(/[^A-Za-z\s]/g, '');
    if (!regex.test(input.value)) {
        input.setCustomValidity("Only letters and spaces are allowed");
    } else {
        input.setCustomValidity("");
    }
}


function validateFees(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}

</script>
<script>

document.getElementById("emailid").addEventListener("input", function(event) {
this.value = this.value.toLowerCase();});
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
