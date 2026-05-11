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
            $branch_id = (string) ($res->fetch_assoc()['branch_id'] ?? '');
        }
        $stmt->close();
    }
}

// ✅ Dynamic Mappings from Database
$branch_map = [];
$b_res = mysqli_query($con, "SELECT id, branch_name FROM branch");
if ($b_res) {
    while ($b_row = mysqli_fetch_assoc($b_res)) {
        $branch_map[(string)$b_row['id']] = $b_row['branch_name'];
    }
}


$service_map = [];
$s_res = mysqli_query($con, "SELECT id, service_name FROM service");
if ($s_res) {
    while ($s_row = mysqli_fetch_assoc($s_res)) {
        $service_map[(string)$s_row['id']] = $s_row['service_name'];
    }
}

if (isset($_POST['loaddetails'])) {
    $selectedDataType = $_POST['location2'] ?? 'enquiry';
    $enquiry_date = $_POST['enquiry_date'] ?? '';
    $enquiry_to_date = $_POST['enquiry_to_date'] ?? '';
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_to_date = $_POST['appointment_to_date'] ?? '';
    $selected_branch = $_POST['location'] ?? 'centres';
    $selected_service = $_POST['department'] ?? 'service';

    $filterdate = "";
    $converteddate = "";
    $converteddate1 = "";

    // ✅ Date Filter Setup
    if ($selectedDataType === 'enquiry' && $enquiry_date && $enquiry_to_date) {
        $filterdate = "b.enquiry_date";
        $converteddate = date("Y-m-d", strtotime($enquiry_date));
        $converteddate1 = date("Y-m-d", strtotime($enquiry_to_date));
    } elseif ($selectedDataType === 'appointment' && $appointment_date && $appointment_to_date) {
        $filterdate = "b.appointment_date";
        $converteddate = date("Y-m-d", strtotime($appointment_date));
        $converteddate1 = date("Y-m-d", strtotime($appointment_to_date));
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
      b.appointment_time,
      t.time_value AS appointment_time_string,
      b.utm_source,
      b.utm_medium,
      b.utm_campaign,
      b.utm_term,
      b.utm_content,
      b.appointment_status,
      b.follow_up_date,
      b.reason
    FROM book_appointment b
    LEFT JOIN appointment_time t ON b.appointment_time = t.id
    WHERE 1=1
    ";

    // ✅ Date Filter
    if ($filterdate && $converteddate && $converteddate1) {
        $sql .= " AND {$filterdate} BETWEEN '" . $con->real_escape_string($converteddate) . "' 
                  AND '" . $con->real_escape_string($converteddate1) . "'";
    }


    // ✅ Branch Filter
    if ($selected_branch !== 'centres' && isset($branch_map[$selected_branch])) {
        $sql .= " AND b.branch = '" . $con->real_escape_string($selected_branch) . "'";
    }

    // ✅ Service Filter
    if ($selected_service !== 'service' && isset($service_map[$selected_service])) {
        $sql .= " AND b.service = '" . $con->real_escape_string($selected_service) . "'";
    }

    // ✅ Restrict to Non-admin user's branch
    if ($user_name !== 'admin' && $branch_id !== '') {
        $sql .= " AND b.branch = '" . $con->real_escape_string($branch_id) . "'";
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
    <meta name="description" content="Gem Cancer Centre" />
    <meta name="author" content="Gem Cancer Centre" />
    <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/plugins/dropzone.min.css" />
    <link href="../../../../cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/monokai-sublime.min.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/plugins/quill.core.css" />
    <link rel="stylesheet" href="assets/css/plugins/quill.snow.css" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="assets/fonts/phosphor/duotone/style.css" />
    <link rel="stylesheet" href="assets/fonts/tabler-icons.min.css" />
    <link rel="stylesheet" href="assets/fonts/feather.css" />
    <link rel="stylesheet" href="assets/fonts/fontawesome.css" />
    <link rel="stylesheet" href="assets/fonts/material.css" />
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="assets/css/style-preset.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
    <style>
        .datatable-search {
            display: none;
        }
    </style>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr"
    data-pc-theme="light">
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
                            value="<?php echo htmlspecialchars($_POST['enquiry_date'] ?? ''); ?>" class="form-control">
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
                            <?php foreach ($branch_map as $val => $name): ?>
                                <option value="<?php echo $val; ?>" <?php echo (isset($_POST['location']) && $_POST['location'] === (string)$val) ? 'selected' : ''; ?>><?php echo htmlspecialchars($name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Select Service</label>
                        <select class="form-control" id="department" name="department">
                            <option value="service" <?php echo (!isset($_POST['department']) || $_POST['department'] === 'service') ? 'selected' : ''; ?>>All</option>
                            <?php foreach ($service_map as $val => $name): ?>
                                <option value="<?php echo $val; ?>" <?php echo (isset($_POST['department']) && $_POST['department'] === $val) ? 'selected' : ''; ?>><?php echo $name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-1 text-right mt-4">
                        <input type="hidden" name="loaddetails" value="Search">
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
                        <input type="hidden" name="enquiry_to_date"
                            value="<?php echo $_POST['enquiry_to_date'] ?? ''; ?>">
                        <input type="hidden" name="appointment_date"
                            value="<?php echo $_POST['appointment_date'] ?? ''; ?>">
                        <input type="hidden" name="appointment_to_date"
                            value="<?php echo $_POST['appointment_to_date'] ?? ''; ?>">
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
                                            <th>Enquiry Date</th>
                                            <th>Appt. Date</th>
                                            <th>Appt. Time</th>
                                            <th>Source</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if ($result && $rowcount > 0): ?>
                                            <?php
                                            $status_labels = [0 => 'Open', 1 => 'Closed', 2 => 'Not Turned Up', 3 => 'Follow-up'];
                                            $status_badges = [0 => 'secondary', 1 => 'success', 2 => 'danger', 3 => 'warning'];
                                            while ($row = $result->fetch_assoc()):
                                                $st = (int) ($row['appointment_status'] ?? 0);
                                                ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                                    <td><?php echo htmlspecialchars($branch_map[$row['branch_display']] ?? $row['branch_display'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($service_map[$row['service_display']] ?? $row['service_display'] ?? '-'); ?></td>
                                                    <td><?php echo !empty($row['enquiry_date']) ? date('d-m-Y', strtotime($row['enquiry_date'])) : '-'; ?>
                                                    </td>
                                                    <td><?php echo !empty($row['appointment_date']) ? date('d-m-Y', strtotime($row['appointment_date'])) : '-'; ?>
                                                    </td>
                                                    <td><?php $time_display = !empty($row['appointment_time_string']) ? $row['appointment_time_string'] : ($row['appointment_time'] ?? '');
                                                         $t_val = $time_display;
                                                         $t_stamp = !empty($t_val) ? strtotime($t_val) : false;
                                                         echo ($t_stamp !== false) ? date('h:i A', $t_stamp) : (!empty($t_val) ? htmlspecialchars($t_val) : '-'); ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($row['utm_source'] ?? 'Direct'); ?></td>
                                                    <td>
                                                        
                                                            <?php echo $status_labels[$st]; ?>
                                                        
                                                    </td>
                                                    <td>
                                                        <?php if ($st === 1): // Closed ?>
                                                            <button type="button" class="btn btn-sm btn-secondary" disabled>Closed</button>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                                data-bs-target="#viewModal" data-id="<?php echo $row['id']; ?>"
                                                                data-status="<?php echo $st; ?>"
                                                                data-followup="<?php echo htmlspecialchars($row['follow_up_date'] ?? ''); ?>"
                                                                data-reason="<?php echo htmlspecialchars($row['reason'] ?? ''); ?>">
                                                                Update
                                                            </button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="11" class="text-center">No records found.</td>
                                            </tr>
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
    <?php include("include/footer.php"); ?>
    <script src="assets/js/plugins/simple-datatables.js"></script>
    <script>
        const dataTable = new simpleDatatables.DataTable('#pc-dt-simple', {
            sortable: false,
            perPage: 20,
            perPageSelect: [20, 30, 40, 50, 100]
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
                                            <option value="0">Open</option>
                                            <option value="1">Closed</option>
                                            <option value="2">Not Turned Up</option>
                                            <option value="3">Follow-up</option>
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
                                        <input type="date" name="follow_up_date" id="followUpDate" class="form-control"
                                            min="<?php echo date('Y-m-d'); ?>">
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
        // Global functions for modal interactions
        function updateFieldVisibility() {
            const statusSelect = document.getElementById('newStatus');
            const followUpField = document.getElementById('followUpField');
            const reasonField = document.getElementById('reasonField');
            const additionalFeesField = document.getElementById('additionalFeesField');
            const mridField = document.getElementById('mridField');
            
            const followUpDateInput = document.getElementById('followUpDate');
            const reasonTextarea = document.getElementById('reason');

            if (!statusSelect) return;

            const selectedValue = statusSelect.value;

            // Hide all fields by default
            if (followUpField) followUpField.style.display = 'none';
            if (reasonField) reasonField.style.display = 'none';
            if (additionalFeesField) additionalFeesField.style.display = 'none';
            if (mridField) mridField.style.display = 'none';

            // Remove required attributes
            if (followUpDateInput) followUpDateInput.removeAttribute('required');
            if (reasonTextarea) reasonTextarea.removeAttribute('required');

            // Show and set required attributes based on selection
            if (selectedValue === '2') {  // Not Turned Up
                if (reasonField) reasonField.style.display = 'block';
                if (reasonTextarea) reasonTextarea.setAttribute('required', 'required');
            } else if (selectedValue === '3') {  // Follow-up
                if (followUpField) followUpField.style.display = 'block';
                if (followUpDateInput) followUpDateInput.setAttribute('required', 'required');
            }
        }

        function resetUpdateForm() {
            const form = document.getElementById('updateForm');
            if (form) {
                form.reset();
                const statusSelect = document.getElementById('newStatus');
                if (statusSelect) {
                    Array.from(statusSelect.options).forEach(opt => opt.disabled = false);
                    statusSelect.options[0].disabled = true; // "Select Status" remains disabled
                }
                updateFieldVisibility();
            }
        }

        // Attach event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('newStatus');
            if (statusSelect) {
                statusSelect.addEventListener('change', updateFieldVisibility);
            }
            
            const viewModal = document.getElementById('viewModal');
            if (viewModal) {
                viewModal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const appointmentId = button.getAttribute('data-id');
                    const currentStatus = button.getAttribute('data-status');
                    const followupDate = button.getAttribute('data-followup');
                    const reason = button.getAttribute('data-reason');

                    document.getElementById('appointmentId').value = appointmentId;
                    document.getElementById('newStatus').value = currentStatus;
                    document.getElementById('followUpDate').value = followupDate || '';
                    document.getElementById('reason').value = reason || '';

                    // Restrictions based on current status
                    const openOption = statusSelect.querySelector('option[value="0"]');
                    if (currentStatus === '3') { 
                        if (openOption) openOption.disabled = true;
                    } else {
                        if (openOption) openOption.disabled = false;
                    }

                    updateFieldVisibility();
                });

                viewModal.addEventListener('hidden.bs.modal', resetUpdateForm);
            }

            const saveChangesBtn = document.getElementById('saveChanges');
            if (saveChangesBtn) {
                saveChangesBtn.addEventListener('click', function () {
                    const form = document.getElementById('updateForm');
                    if (!form.checkValidity()) {
                        form.reportValidity();
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
                            const modal = bootstrap.Modal.getInstance(viewModal) || new bootstrap.Modal(viewModal);
                            modal.hide();
                            alert('Data updated successfully!');
                            document.getElementById('filterForm').submit();
                        } else {
                            alert('Error: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating the status.');
                    });
                });
            }
        });
    </script>




    <script src="assets/js/plugins/popper.min.js"></script>
    <script src="assets/js/plugins/simplebar.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/fonts/custom-font.js"></script>
    <script src="assets/js/pcoded.js"></script>
    <script src="assets/js/plugins/feather.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var selectData = document.querySelector('select[name="location2"]');
            var enquiryDiv = document.querySelector('.enquiry');
            var enquiryToDiv = document.querySelector('.enquiry_to');
            var appointmentDiv = document.querySelector('.appointment');
            var appointmentToDiv = document.querySelector('.appointment_to');
            var enquiryDateInput = document.querySelector('input[name="enquiry_date"]');
            var enquiryToDateInput = document.querySelector('input[name="enquiry_to_date"]');
            var appointmentDateInput = document.querySelector('input[name="appointment_date"]');
            var appointmentToDateInput = document.querySelector('input[name="appointment_to_date"]');
            selectData.addEventListener('change', function () {
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