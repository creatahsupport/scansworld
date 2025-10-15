<?php 
include("../includes/config.php");
include_once("include/header.php"); 

$branch = $_GET['id'] ?? null; // Get the branch ID from the query string
$branchs = [];
$SELECTED_LOCATION1 = [];

if ($branch) {
    // Fetch branch details
    $query = "SELECT * FROM branch WHERE id = '$branch'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $branchs = mysqli_fetch_assoc($result);
        $SELECTED_LOCATION1 = explode(',', $branchs['branch_time'] ?? '');
    } else {
        echo "Branch not found.";
    }
}

// Function to check if a value is in the selected locations array
function is_checked1($needle, array $array_stack) {
    return in_array($needle, $array_stack) ? "checked" : "";
}
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
                  <h2 class="mb-0">Edit Branch</h2>
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
        <form method="POST" action="update_location.php" enctype="multipart/form-data" onsubmit="return validateForm()">
    <input type="hidden" name="branch_id" value="<?php echo $branchs['id']; ?>" />
    <div class="row">
        <!-- Branch Name -->
        <div class="col-md-4 mb-3">
            <label for="editBranchName">Branch Name</label>
            <input type="text" class="form-control" required id="editBranchName" name="branch" placeholder="Enter Branch Name" value="<?php echo $branchs['branch_name']; ?>" oninput="validateBranchName(this)">
        </div>

        <!-- Fees -->
        <div class="col-md-4 mb-3">
            <label for="editFees">Fees</label>
            <input type="text" class="form-control" required id="editFees" name="fees" placeholder="Enter Amount" value="<?php echo $branchs['fees']; ?>">
        </div>

        <!-- SMS Number -->
        <div class="col-md-4 mb-3">
            <label for="editSmsNumber">SMS Number</label>
            <input type="text" class="form-control" required id="editSmsNumber" name="sms_number" placeholder="Enter 10-Digit SMS Number" value="<?php echo $branchs['sms_number']; ?>" oninput="validateSmsNumber(this)">
        </div>
    </div>

    <div class="row">
        <!-- To Email -->
        <div class="col-md-4 mb-3">
            <label for="editToEmail">To Email (Multiple emails use comma separator)</label>
            <input type="text" class="form-control" required id="editToEmail" name="to_email" placeholder="To Email" value="<?php echo $branchs['to_email']; ?>">
        </div>

        <!-- CC Email -->
        <div class="col-md-4 mb-3">
            <label for="editCcEmail">CC Email (Multiple emails use comma separator)</label>
            <input type="text" class="form-control" required id="editCcEmail" name="cc_mail" placeholder="CC Email" value="<?php echo $branchs['cc_email']; ?>">
        </div>

        <!-- Status -->
        <div class="col-md-4 mb-3">
            <label for="editStatus">Status</label>
            <select class="form-control" required name="status" id="editStatus">
                <option value="">Select Status</option>
                <option value="1" <?php echo $branchs['status'] == 1 ? 'selected' : ''; ?>>Active</option>
                <option value="0" <?php echo $branchs['status'] == 0 ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>
    </div>

    <div class="mb-3">
        <strong>Time</strong>
        <div class="row">
            <!-- Select All Checkbox -->
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkall1">
                    <label class="form-check-label" for="checkall1">All</label>
                </div>
            </div>

            <?php
            // Fetch appointment times
            $csql = mysqli_query($con, "
                SELECT * FROM appoinment_time 
                ORDER BY 
                CASE 
                    WHEN SUBSTRING_INDEX(time, ' ', -1) = 'AM' THEN STR_TO_DATE(time, '%h:%i %p') 
                    ELSE STR_TO_DATE(time, '%h:%i %p') + INTERVAL 12 HOUR 
                END ASC");

            if ($csql) {
                while ($csql1 = mysqli_fetch_assoc($csql)) { ?>
                    <!-- Checkbox for each appointment time -->
                    <div class="col-md-4">
                        <div class="form-check">
                            <input 
                                class="form-check-input time" 
                                type="checkbox" 
                                name="time[]" 
                                id="CP<?= $csql1['id'] ?>" 
                                <?= is_checked1($csql1['id'], $SELECTED_LOCATION1) ?> 
                                value="<?= $csql1['id']; ?>"
                            >
                            <label class="form-check-label" for="CP<?= $csql1['id'] ?>">
                                <?= htmlspecialchars($csql1['time']); ?>
                            </label>
                        </div>
                    </div>
                <?php }
            } else {
                echo "<div class='col-md-12'>No times available.</div>";
            }
            ?>
        </div>
    </div>
    <input type="hidden" name="user_id" value="<?php echo $user_name;?>">
    <div class="text-end mt-4">
        <button type="submit" name="addlocation" class="btn btn-primary">Submit</button>
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

function validateSmsNumber(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
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
