<?php
// book_appointment_report.php
declare(strict_types=1);

include("../includes/config.php");
include_once("include/header.php");

// Logged-in user
$user_name = $user_name ?? ($_SESSION['user_name'] ?? '');

// ===============================
// REPORT DASHBOARD
// ===============================
$result = null;
$rowcount = 0;

// For non-admin users, fetch their restricted branch
$branch_id = '';
if ($user_name && $user_name !== 'admin') {
    $sqlUB = "SELECT branch_id FROM admin WHERE user_name = ?";
    if ($stmt = $con->prepare($sqlUB)) {
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows > 0) {
            $branch_id = (string)($res->fetch_assoc()['branch_id'] ?? '');
        }
        $stmt->close();
    }
}

if (isset($_POST['loaddetails'])) {
    $selectedDataType     = $_POST['location2'] ?? 'enquiry';
    $enquiry_date         = $_POST['enquiry_date'] ?? '';
    $enquiry_to_date      = $_POST['enquiry_to_date'] ?? '';
    $appointment_date     = $_POST['appointment_date'] ?? '';
    $appointment_to_date  = $_POST['appointment_to_date'] ?? '';
    $selected_branch      = $_POST['location'] ?? 'centres';
    $selected_service     = $_POST['department'] ?? 'service';

    $filterdate    = "";
    $converteddate = "";
    $converteddate1= "";

    // ✅ Date Filter Setup
    if ($selectedDataType === 'enquiry' && $enquiry_date && $enquiry_to_date) {
        $filterdate    = "b.enquiry_date";
        $converteddate = date("Y-m-d", strtotime($enquiry_date));
        $converteddate1= date("Y-m-d", strtotime($enquiry_to_date));
    } elseif ($selectedDataType === 'appointment' && $appointment_date && $appointment_to_date) {
        $filterdate    = "b.appointment_date";
        $converteddate = date("Y-m-d", strtotime($appointment_date));
        $converteddate1= date("Y-m-d", strtotime($appointment_to_date));
    }

    // ✅ Base Query
    $sql = "
    SELECT 
      b.id,
      b.patient_name,
      b.phone,
      b.branch AS branch_display,
      b.service AS service_display,
      b.test_name,
      b.enquiry_date,
      b.appointment_date,
      b.appointment_time
    FROM book_appointment b
    WHERE 1=1
    ";

    // ✅ Date Filter
    if ($filterdate && $converteddate && $converteddate1) {
        $sql .= " AND {$filterdate} BETWEEN '".$con->real_escape_string($converteddate)."' 
                  AND '".$con->real_escape_string($converteddate1)."'";
    }

    // ✅ Static Mappings (used for filtering)
    $branch_map = [
        "1" => "Nandanam",
        "2" => "Nanganallur",
        "3" => "Aminjikarai"
    ];

    $service_map = [
        "1" => "MRI",
        "2" => "CT",
        "3" => "X-Ray",
        "4" => "ECG"
    ];

    // ✅ Branch Filter
    if ($selected_branch !== 'centres' && isset($branch_map[$selected_branch])) {
        $branch_name = $branch_map[$selected_branch];
        $sql .= " AND b.branch = '".$con->real_escape_string($branch_name)."'";
    }

    // ✅ Service Filter
    if ($selected_service !== 'service' && isset($service_map[$selected_service])) {
        $service_name = $service_map[$selected_service];
        $sql .= " AND b.service = '".$con->real_escape_string($service_name)."'";
    }

    // ✅ Restrict to Non-admin user's branch
    if ($user_name !== 'admin' && $branch_id !== '') {
        if (isset($branch_map[$branch_id])) {
            $branch_name = $branch_map[$branch_id];
            $sql .= " AND b.branch = '".$con->real_escape_string($branch_name)."'";
        }
    }

    // ✅ Sort order
    $sql .= " ORDER BY b.id DESC";

    // ✅ Execute
    $result = mysqli_query($con, $sql);
    $rowcount = $result ? mysqli_num_rows($result) : 0;
}

?>

<!doctype html>
<html lang="en">
<head>
    <title>Book Appointment Report | Gem Cancer Centre</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Gem Cancer Centre"/>
    <meta name="author" content="Gem Cancer Centre" />
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
    <style>
        .datatable-search{
            display:none;
        }
    </style>
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
                            <div class="page-header-title">
                                <h3 class="mb-0">Book Appointment Report</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <form method="POST" action="book_appointment_report.php" id="filterForm">
                <div class="form-group row">
                    <div class="col-md-2">
                        <label>Select Data</label>
                        <select class="form-control" name="location2" id="location2">
                            <option value="enquiry" selected>Enquiry</option>
                        </select>
                    </div>
                    <div class="col-md-2 enquiry">
                        <label>Enquiry From Date</label>
                        <input type="date" name="enquiry_date" id="enquiry_date" 
                               value="<?php echo htmlspecialchars($_POST['enquiry_date'] ?? ''); ?>" 
                               class="form-control">
                    </div>
                    <div class="col-md-2 enquiry_to">
                        <label>Enquiry To Date</label>
                        <input type="date" name="enquiry_to_date" id="enquiry_to_date" 
                               value="<?php echo htmlspecialchars($_POST['enquiry_to_date'] ?? ''); ?>" 
                               class="form-control">
                    </div>
                    <!-- ✅ Static Centre and Service Filters -->
<div class="col-md-2">
  <label>Select Centre</label>
  <select class="form-control" id="location" name="location">
    <option value="centres" <?php echo (!isset($_POST['location']) || $_POST['location'] === 'centres') ? 'selected' : ''; ?>>All</option>
    <option value="1" <?php echo (isset($_POST['location']) && $_POST['location'] === '1') ? 'selected' : ''; ?>>Nandanam</option>
    <option value="2" <?php echo (isset($_POST['location']) && $_POST['location'] === '2') ? 'selected' : ''; ?>>Nanganallur</option>
    <option value="3" <?php echo (isset($_POST['location']) && $_POST['location'] === '3') ? 'selected' : ''; ?>>Aminjikarai</option>
  </select>
</div>

<div class="col-md-2">
  <label>Select Service</label>
  <select class="form-control" id="department" name="department">
    <option value="service" <?php echo (!isset($_POST['department']) || $_POST['department'] === 'service') ? 'selected' : ''; ?>>All</option>
    <option value="1" <?php echo (isset($_POST['department']) && $_POST['department'] === '1') ? 'selected' : ''; ?>>MRI</option>
    <option value="2" <?php echo (isset($_POST['department']) && $_POST['department'] === '2') ? 'selected' : ''; ?>>CT</option>
    <option value="3" <?php echo (isset($_POST['department']) && $_POST['department'] === '3') ? 'selected' : ''; ?>>X-Ray</option>
    <option value="4" <?php echo (isset($_POST['department']) && $_POST['department'] === '4') ? 'selected' : ''; ?>>ECG</option>
  </select>
</div>

                    <div class="col-md-1 text-right mt-4">
                        <input type="submit" value="Search" name="loaddetails" class="btn btn-primary btn-lg">
                    </div>
                    <!-- <div class="col-md-1 text-right mt-4">
                        <input type="button" onclick="resetForm()" value="Reset" name="loaddetails1" class="btn btn-danger btn-lg">
                    </div> -->
                  
            </form>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    function resetForm() {
        $("#enquiry_date").val("");
        $("#enquiry_to_date").val("");
        $("#appointment_date").val("");
        $("#appointment_to_date").val("");
        $("#location").val("centres");
        $("#department").val("service");
        $("#status_bar").val("all_bar");
        $("#status_val").val("all");
        $("#patient_status").val("all_status");
    }
</script>
<div class="row pt-3">
                    <div class="col-sm-12">
<form method="post" action="appointment_export.php">
    <input type="hidden" name="department" value="<?php echo $_POST['department'] ?? 'service'; ?>">
    <input type="hidden" name="location" value="<?php echo $_POST['location'] ?? 'centres'; ?>">
    <input type="hidden" name="enquiry_date" value="<?php echo $_POST['enquiry_date'] ?? ''; ?>">
    <input type="hidden" name="enquiry_to_date" value="<?php echo $_POST['enquiry_to_date'] ?? ''; ?>">
    <input type="hidden" name="appointment_date" value="<?php echo $_POST['appointment_date'] ?? ''; ?>">
    <input type="hidden" name="appointment_to_date" value="<?php echo $_POST['appointment_to_date'] ?? ''; ?>">
    <button type="submit" name="export_to_excel" class="btn btn-success">Export to Excel</button>
</form>
</div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card border-0 table-card user-profile-list">
                            <div class="card-body">
                                <div class="table-responsive">
                                   <table class="table table-hover" id="pc-dt-simple">
                                   <thead>
                                      <tr>
                                        <th>ID</th>
                                        <th>Patient Name</th>
                                        <th>Phone</th>
                                        <th>Branch</th>
                                        <th>Service</th>
                                        <th>Test Name</th>
                                        <th>Enquiry Date</th>
                                        <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                      </tr>
                                   </thead>

                                   <tbody>
                                      <?php if ($result && $rowcount > 0): ?>
                                          <?php while ($row = $result->fetch_assoc()): ?>
                                              <tr>
                                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                  <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                                  <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                                  <td><?php echo htmlspecialchars($row['branch_display'] ?? '-'); ?></td>
                                                  <td><?php echo htmlspecialchars($row['service_display'] ?? '-'); ?></td>
                                                  <td><?php echo htmlspecialchars($row['test_name'] ?? '-'); ?></td>
                                                  <td><?php echo !empty($row['enquiry_date']) ? date("d-m-Y", strtotime($row['enquiry_date'])) : "-"; ?></td>
                                                  <td><?php echo !empty($row['appointment_date']) ? date("d-m-Y", strtotime($row['appointment_date'])) : "-"; ?></td>
                                                  <td><?php echo !empty($row['appointment_time']) ? date("h:i A", strtotime($row['appointment_time'])) : "-"; ?></td>
                                              </tr>
                                          <?php endwhile; ?>
                                      <?php else: ?>
                                          <tr><td colspan="8" class="text-center">No records found.</td></tr>
                                      <?php endif; ?>
                                   </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <?php include("include/footer.php");?>
    <script src="assets/js/plugins/simple-datatables.js"></script>
    <script>
      const dataTable = new simpleDatatables.DataTable('#pc-dt-simple', {
        sortable: false,
        perPage: 50
      });
    </script>
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">Appointment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm">
                    <div id="appointmentDetails">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="newStatus" class="control-label">Change Status</label>
                                    <select name="status" id="newStatus" class="form-control" required>
                                        <option value="" disabled>Select Status</option>
                                        <option value="0">Not Turned</option>
                                        <option value="1">Turned</option>
                                        <option value="2">Follow Up</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="additionalFeesField" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="fees" class="control-label">Additional Fees</label>
                                    <input type="text" name="fees" id="fees" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6" id="mridField" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="fees" class="control-label">Mrid</label>
                                    <input type="text" name="mrid_no" id="mrid_no" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6" id="followUpField" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="followUpDate" class="control-label">Follow Up Date</label>
                                    <input type="date" name="follow_up_date" id="followUpDate" class="form-control" min="<?php echo date('Y-m-d'); ?>">
                                </div>
                            </div>
                            <div class="col-md-12" id="reasonField" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="reason" class="control-label">Reason</label>
                                    <textarea class="form-control" name="reason" id="reason"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="appointmentId">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChanges">Save Changes</button>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('newStatus');
    const additionalFeesField = document.getElementById('additionalFeesField');
    const mridField = document.getElementById('mridField');
    const followUpField = document.getElementById('followUpField');
    const reasonField = document.getElementById('reasonField');
    const feesInput = document.getElementById('fees');
    const mrid_noInput = document.getElementById('mrid_no');
    const followUpDateInput = document.getElementById('followUpDate');
    const reasonTextarea = document.getElementById('reason');

    function updateFieldVisibility() {
        const selectedValue = statusSelect.value;

        // Hide all fields by default
        additionalFeesField.style.display = 'none';
        mridField.style.display = 'none';
        followUpField.style.display = 'none';
        reasonField.style.display = 'none';

        // Remove required attributes
        feesInput.removeAttribute('required');
        mrid_noInput.removeAttribute('required');
        followUpDateInput.removeAttribute('required');
        reasonTextarea.removeAttribute('required');

        // Show and set required attributes based on selection
        if (selectedValue === '0' || selectedValue === '2') {
            reasonField.style.display = 'block';
            reasonTextarea.setAttribute('required', 'required');
        }
        if (selectedValue === '1') {
            additionalFeesField.style.display = 'block';
            feesInput.setAttribute('required', 'required');
            mridField.style.display = 'block';
            mrid_noInput.setAttribute('required', 'required');
        }
        if (selectedValue === '2') {
            followUpField.style.display = 'block';
            followUpDateInput.setAttribute('required', 'required');
        }
    }

    function resetUpdateForm() {
        document.getElementById('updateForm').reset();
        updateFieldVisibility();
    }

    function loadAppointmentDetails(button) {
        const appointmentId = button.getAttribute('data-id');
        document.getElementById('appointmentId').value = appointmentId;
        fetchDetailsAndSetStatus(appointmentId);
    }

    function fetchDetailsAndSetStatus(appointmentId) {
        // Simulating fetching of appointment details
        resetUpdateForm();
    }

    statusSelect.addEventListener('change', updateFieldVisibility);
    updateFieldVisibility();

    $('#viewModal').on('hidden.bs.modal', function () {
        resetUpdateForm();
    });

    document.getElementById('saveChanges').addEventListener('click', function () {
        const form = document.getElementById('updateForm');

        // Validate required fields before submitting
        if (!form.checkValidity()) {
            form.reportValidity(); // Show validation messages
            return;
        }

        const formData = new FormData(form);
        fetch('status_update.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('viewModal'));
                modal.hide();
                document.querySelector('.modal-backdrop')?.remove();
                alert('Data updated successfully!');
                resetUpdateForm();
            } else {
                alert('Error: ' + data.error);
            }
        });
    });
});

function loadAppointmentDetails(button) {
    const appointmentId = button.getAttribute('data-id');
    document.getElementById('appointmentId').value = appointmentId;
    // Fetch appointment details or status again if necessary here
    // Example: fetchStatus(appointmentId);
    resetUpdateForm(); // Call reset to ensure form is clean before setting new values
}

function resetUpdateForm() {
    document.getElementById('updateForm').reset();
    updateFieldVisibility(); // Refresh visibility and requirement states immediately after reset
}
</script>




<script src="assets/js/plugins/popper.min.js"></script>
<script src="assets/js/plugins/simplebar.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/fonts/custom-font.js"></script>
<script src="assets/js/pcoded.js"></script>
<script src="assets/js/plugins/feather.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectData = document.querySelector('select[name="location2"]');
        var enquiryDiv = document.querySelector('.enquiry');
        var enquiryToDiv = document.querySelector('.enquiry_to');
        var appointmentDiv = document.querySelector('.appointment');
        var appointmentToDiv = document.querySelector('.appointment_to');
        var enquiryDateInput = document.querySelector('input[name="enquiry_date"]');
        var enquiryToDateInput = document.querySelector('input[name="enquiry_to_date"]');
        var appointmentDateInput = document.querySelector('input[name="appointment_date"]');
        var appointmentToDateInput = document.querySelector('input[name="appointment_to_date"]');
        selectData.addEventListener('change', function() {
            if (this.value === 'enquiry') {
                enquiryDiv.style.display = 'block';
                enquiryToDiv.style.display = 'block';
                appointmentDiv.style.display = 'none';
                appointmentToDiv.style.display = 'none';
                enquiryDateInput.required = true;
                enquiryToDateInput.required = true;
                appointmentDateInput.required = false;
                appointmentToDateInput.required = false;
            } else if (this.value === 'appointment') {
                enquiryDiv.style.display = 'none';
                enquiryToDiv.style.display = 'none';
                appointmentDiv.style.display = 'block';
                appointmentToDiv.style.display = 'block';
                appointmentDateInput.required = true;
                appointmentToDateInput.required = true;
                enquiryDateInput.required = false;
                enquiryToDateInput.required = false;
            }
        });
        selectData.dispatchEvent(new Event('change'));
    });
</script>
</body>
</html>

