<?php
// book_appointment_report.php
declare(strict_types=1);

include("../includes/config.php");
include_once("include/header.php");

// Logged-in user (from header/session)
$user_name = $user_name ?? ($_SESSION['user_name'] ?? '');

// ===============================
// FRONTEND BOOKING INSERT (form POST from public page hitting this file)
// ===============================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['loaddetails'])) {
    $patient_name     = trim($_POST['name'] ?? '');
    $phone            = trim($_POST['phone'] ?? '');
    $branch           = trim($_POST['branch'] ?? '');   // Branch ID
    $service          = trim($_POST['service'] ?? '');  // Service ID
    $appointment_date = trim($_POST['date'] ?? '');
    $appointment_time = trim($_POST['time'] ?? '');
    $enquiry_date     = date('Y-m-d');

    // Basic validation (prevents saving 0/empty which breaks joins later)
    if ($patient_name === '' || $phone === '' || $appointment_date === '' || $appointment_time === '' ||
        $branch === '' || $branch === '0' || $service === '' || $service === '0') {
        echo "<script>alert('Please fill all fields and choose a valid Centre & Service.'); history.back();</script>";
        exit;
    }

    // Insert using prepared statements
    $sql = "INSERT INTO book_appointment 
            (patient_name, phone, appointment_date, branch, appointment_time, service, enquiry_date, status, fees) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 0, 0)";
    if ($stmt = $con->prepare($sql)) {
        $stmt->bind_param(
            "sssssss",
            $patient_name,
            $phone,
            $appointment_date,
            $branch,            // ID
            $appointment_time,
            $service,           // ID
            $enquiry_date
        );
        $ok = $stmt->execute();
        $stmt->close();

        if ($ok) {
            $subject = "New Appointment Booking - Scans World";
            // Make booking vars available to template if needed
            foreach ([
                'patient_name' => htmlspecialchars($patient_name, ENT_QUOTES),
                'phone' => htmlspecialchars($phone, ENT_QUOTES),
                'appointment_date' => htmlspecialchars($appointment_date, ENT_QUOTES),
                'appointment_time' => htmlspecialchars($appointment_time, ENT_QUOTES),
                'branch' => htmlspecialchars($branch, ENT_QUOTES),
                'service' => htmlspecialchars($service, ENT_QUOTES),
                'enquiry_date' => htmlspecialchars($enquiry_date, ENT_QUOTES),
            ] as $k => $v) { $$k = $v; }

            ob_start();
            include("contact_us_email_template.php");
            $message_content = ob_get_clean();

            $to_email = "creatahmailinquiry@gmail.com";
            $cc_email = "";
            if (function_exists('mailer')) {
                mailer($subject, $message_content, $to_email, $cc_email);
            }

            echo "<script>alert('Thank you! Your appointment has been booked successfully.'); window.location.href='thank-you.php';</script>";
            exit;
        } else {
            echo "<script>alert('Database error while booking.'); history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Server error.'); history.back();</script>";
        exit;
    }
}

// ===============================
// REPORT DASHBOARD
// ===============================
$result = null;
$rowcount = 0;

if (isset($_POST['loaddetails'])) {
    $department           = $_POST['department'] ?? 'service';
    $location             = $_POST['location'] ?? 'centres';
    $selectedDataType     = $_POST['location2'] ?? 'enquiry'; // 'enquiry' | 'appointment'

    $enquiry_date         = $_POST['enquiry_date'] ?? '';
    $enquiry_to_date      = $_POST['enquiry_to_date'] ?? '';
    $appointment_date     = $_POST['appointment_date'] ?? '';
    $appointment_to_date  = $_POST['appointment_to_date'] ?? '';

    $filterdate    = "";
    $converteddate = "";
    $converteddate1= "";

    if ($selectedDataType === 'enquiry' && $enquiry_date !== '' && $enquiry_to_date !== '') {
        $filterdate    = "b.enquiry_date";
        $converteddate = date("Y-m-d", strtotime($enquiry_date));
        $converteddate1= date("Y-m-d", strtotime($enquiry_to_date));
    } elseif ($selectedDataType === 'appointment' && $appointment_date !== '' && $appointment_to_date !== '') {
        $filterdate    = "b.appointment_date";
        $converteddate = date("Y-m-d", strtotime($appointment_date));
        $converteddate1= date("Y-m-d", strtotime($appointment_to_date));
    }

    // Robust SELECT: shows branch/service name if join works; otherwise falls back to raw values
$sql = "SELECT 
          b.*,
         COALESCE(
  (SELECT branch_name FROM branch WHERE id = b.branch LIMIT 1),
  CASE WHEN b.branch = 0 THEN 'Not Selected' ELSE b.branch END
) AS branch_display,
COALESCE(
  (SELECT service_name FROM service WHERE id = b.service LIMIT 1),
  CASE WHEN b.service = 0 THEN 'Not Selected' ELSE b.service END
) AS service_display

        FROM book_appointment b
        WHERE 1=1";


    if ($filterdate && $converteddate && $converteddate1) {
        $sql .= " AND {$filterdate} BETWEEN '".$con->real_escape_string($converteddate)."' 
                                  AND '".$con->real_escape_string($converteddate1)."'";
    }

    if ($location !== "centres" && $location !== '') {
        $sql .= " AND b.branch = '". $con->real_escape_string($location) ."'";
    }

    if ($department !== "service" && $department !== '') {
        $sql .= " AND b.service = '". $con->real_escape_string($department) ."'";
    }

    $sql .= " ORDER BY b.id DESC";

    $result = mysqli_query($con, $sql);
    $rowcount = $result ? mysqli_num_rows($result) : 0;
}

// For non-admin users, fetch their restricted branch for the Centre dropdown
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
?>
<!doctype html>
<html lang="en">
<head>
    <title>Book Appointment Report | Scans World</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="<?php echo $favicon ?? ''; ?>" type="image/x-icon" />
    <link rel="stylesheet" href="assets/css/style.css" id="main-style-link" />
    <link rel="stylesheet" href="assets/css/style-preset.css" />
</head>
<body>
    <?php include("include/sidebar.php"); ?>
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

            <!-- Filter Form -->
            <form method="POST" action="book_appointment_report.php" id="filterForm">
                <div class="form-group row">
                    <div class="col-md-2">
                        <label>Select Data</label>
                        <select class="form-control" name="location2" id="location2">
                            <option value="enquiry" <?php echo ($_POST['location2'] ?? '') !== 'appointment' ? 'selected' : ''; ?>>Enquiry</option>
                            <!-- <option value="appointment" <?php echo ($_POST['location2'] ?? '') === 'appointment' ? 'selected' : ''; ?>>Appointment</option> -->
                        </select>
                    </div>
                    <div class="col-md-2 enquiry">
                        <label>Enquiry From Date</label>
                        <input type="date" name="enquiry_date" id="enquiry_date" value="<?php echo htmlspecialchars($_POST['enquiry_date'] ?? ''); ?>" class="form-control">
                    </div>
                    <div class="col-md-2 enquiry_to">
                        <label>Enquiry To Date</label>
                        <input type="date" name="enquiry_to_date" id="enquiry_to_date" value="<?php echo htmlspecialchars($_POST['enquiry_to_date'] ?? ''); ?>" class="form-control">
                    </div>
                    <div class="col-md-2 appointment" style="display:none;">
                        <label>Appointment From Date</label>
                        <input type="date" name="appointment_date" id="appointment_date" value="<?php echo htmlspecialchars($_POST['appointment_date'] ?? ''); ?>" class="form-control">
                    </div>
                    <div class="col-md-2 appointment_to" style="display:none;">
                        <label>Appointment To Date</label>
                        <input type="date" name="appointment_to_date" id="appointment_to_date" value="<?php echo htmlspecialchars($_POST['appointment_to_date'] ?? ''); ?>" class="form-control">
                    </div>

                    <?php if ($user_name === 'admin') { ?>
                        <div class="col-md-3">
                            <label>Select Centre</label>
                            <select class="form-control" id="location" name="location">
                                <option value="centres" <?php echo (($_POST['location'] ?? '') === 'centres' || !isset($_POST['location'])) ? 'selected' : ''; ?>>All</option>
                                <?php
                                $rs = $con->query("SELECT id, branch_name FROM branch WHERE del_i=0 ORDER BY branch_name ASC");
                                if ($rs) {
                                    while ($r = $rs->fetch_assoc()) {
                                        $sel = (isset($_POST['location']) && $_POST['location'] == $r['id']) ? "selected" : "";
                                        echo "<option value='{$r['id']}' {$sel}>{$r['branch_name']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    <?php } else { ?>
                        <div class="col-md-3">
                            <label>Select Centre</label>
                            <select class="form-control" id="location" name="location">
                                <?php
                                if ($branch_id !== '') {
                                    $stmtB = $con->prepare("SELECT id, branch_name FROM branch WHERE del_i=0 AND id=? LIMIT 1");
                                    $stmtB->bind_param("s", $branch_id);
                                    $stmtB->execute();
                                    $resB = $stmtB->get_result();
                                    if ($resB && $resB->num_rows > 0) {
                                        $rb = $resB->fetch_assoc();
                                        echo "<option value='{$rb['id']}' selected>{$rb['branch_name']}</option>";
                                    } else {
                                        echo "<option value='' selected>No Branch Assigned</option>";
                                    }
                                    $stmtB->close();
                                } else {
                                    echo "<option value='' selected>No Branch Assigned</option>";
                                }
                                ?>
                            </select>
                        </div>
                    <?php } ?>

                    <div class="col-md-3">
                        <label>Select Service</label>
                        <select class="form-control" id="department" name="department">
                            <option value="service" <?php echo (($_POST['department'] ?? '') === 'service' || !isset($_POST['department'])) ? 'selected' : ''; ?>>All</option>
                            <?php
                            $rsS = $con->query("SELECT id, service_name FROM service WHERE del_i=0 ORDER BY service_name ASC");
                            if ($rsS) {
                                while ($s = $rsS->fetch_assoc()) {
                                    $sel = (isset($_POST['department']) && $_POST['department'] == $s['id']) ? "selected" : "";
                                    echo "<option value='{$s['id']}' {$sel}>{$s['service_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row mt-3" style="padding-left: 420px;">
                    <div class="col-md-2 text-right">
                        <input type="submit" value="Search" name="loaddetails" class="btn btn-primary btn-lg">
                    </div>
                    <div class="col-md-2 text-right">
                        <input type="button" onclick="resetForm()" value="Reset" class="btn btn-danger btn-lg">
                    </div>
                </div>
            </form>

            <!-- Appointment Table -->
            <div class="row mt-3">
                <div class="col-sm-12">
                    <div class="card border-0 table-card user-profile-list">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="pc-dt-simple">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Patient Name</th>
                                            <th>Phone</th>
                                            <th>Branch</th>
                                            <th>Service</th>
                                            <th>Enquiry Date</th>
                                            <th>Appointment Date</th>
                                            <th>Appointment Time</th>
                                            <th>Status</th>
                                            <th>Follow-up Date</th>
                                            <th>Fees</th>
                                            <th>Reason</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($result && $rowcount > 0): ?>
                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo (int)$row['id']; ?></td>
                                                    <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['branch_display'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($row['service_display'] ?? '-'); ?></td>
                                                    <td><?php echo !empty($row['enquiry_date']) ? date("d-m-Y", strtotime($row['enquiry_date'])) : "-"; ?></td>
                                                    <td><?php echo !empty($row['appointment_date']) ? date("d-m-Y", strtotime($row['appointment_date'])) : "-"; ?></td>
                                                    <td><?php echo !empty($row['appointment_time']) ? date("h:i A", strtotime($row['appointment_time'])) : "-"; ?></td>
                                                    <td>
                                                        <?php
                                                            $status = (int)$row['status'];
                                                            echo $status === 0 ? "Not Turned" : ($status === 1 ? "Turned" : ($status === 2 ? "Follow-Up" : "Unknown"));
                                                        ?>
                                                    </td>
                                                    <td><?php echo !empty($row['follow_up_date']) ? date("d-m-Y", strtotime($row['follow_up_date'])) : "-"; ?></td>
                                                    <td><?php echo isset($row['fees']) ? htmlspecialchars((string)$row['fees']) : '0'; ?></td>
                                                    <td><?php echo !empty($row['reason']) ? htmlspecialchars($row['reason']) : '-'; ?></td>
                                                    <td>
                                                        <?php if ((int)$row['status'] === 0 || (int)$row['status'] === 2): ?>
                                                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#viewModal" data-id="<?php echo (int)$row['id']; ?>" onclick="loadAppointmentDetails(this)">View</button>
                                                        <?php elseif ((int)$row['status'] === 1): ?>
                                                            <button type="button" class="btn btn-secondary" disabled>Closed</button>
                                                        <?php else: ?>
                                                            -
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr><td colspan="13" class="text-center">No records found. Please apply filters and search.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <?php if ($result instanceof mysqli_result) { $result->free(); } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- pc-content -->
    </div><!-- pc-container -->

    <?php include("include/footer.php");?>

    <!-- Needed scripts only -->
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/plugins/simplebar.min.js"></script>
    <script src="assets/js/plugins/simple-datatables.js"></script>
    <script src="assets/js/pcoded.js"></script>

    <script>
      // DataTable
      const dataTable = new simpleDatatables.DataTable('#pc-dt-simple', {
        sortable: false,
        perPage: 10
      });

      // Reset filters
      function resetForm() {
        document.getElementById('filterForm').reset();
        document.getElementById('location2').value = 'enquiry';
        document.getElementById('location2').dispatchEvent(new Event('change'));
      }

      // Show correct date filter block
      document.addEventListener('DOMContentLoaded', function () {
        const selectData = document.getElementById('location2');
        const enquiryDiv = document.querySelector('.enquiry');
        const enquiryToDiv = document.querySelector('.enquiry_to');
        const appointmentDiv = document.querySelector('.appointment');
        const appointmentToDiv = document.querySelector('.appointment_to');

        const enquiryDateInput = document.querySelector('input[name="enquiry_date"]');
        const enquiryToDateInput = document.querySelector('input[name="enquiry_to_date"]');
        const appointmentDateInput = document.querySelector('input[name="appointment_date"]');
        const appointmentToDateInput = document.querySelector('input[name="appointment_to_date"]');

        function toggleDateBlocks() {
          if (selectData.value === 'enquiry') {
            enquiryDiv.style.display = 'block';
            enquiryToDiv.style.display = 'block';
            appointmentDiv.style.display = 'none';
            appointmentToDiv.style.display = 'none';

            enquiryDateInput.required = true;
            enquiryToDateInput.required = true;
            appointmentDateInput.required = false;
            appointmentToDateInput.required = false;
          } else {
            enquiryDiv.style.display = 'none';
            enquiryToDiv.style.display = 'none';
            appointmentDiv.style.display = 'block';
            appointmentToDiv.style.display = 'block';

            appointmentDateInput.required = true;
            appointmentToDateInput.required = true;
            enquiryDateInput.required = false;
            enquiryToDateInput.required = false;
          }
        }

        selectData.addEventListener('change', toggleDateBlocks);
        toggleDateBlocks();
      });

      // Modal: push selected row id
      function loadAppointmentDetails(button) {
        const appointmentId = button.getAttribute('data-id');
        document.getElementById('appointmentId').value = appointmentId;
      }
    </script>

    <!-- Status Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="viewModalLabel">Appointment Details</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="updateForm">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group mb-3">
                                  <label for="newStatus" class="control-label">Change Status</label>
                                  <select name="status" id="newStatus" class="form-control" required>
                                      <option value="" disabled selected>Select Status</option>
                                      <option value="0">Not Turned</option>
                                      <option value="1">Turned</option>
                                      <option value="2">Follow Up</option>
                                  </select>
                              </div>
                          </div>
                          <div class="col-md-6" id="additionalFeesField" style="display:none;">
                              <div class="form-group mb-3">
                                  <label for="fees" class="control-label">Additional Fees</label>
                                  <input type="number" step="0.01" name="fees" id="fees" class="form-control" placeholder="0">
                              </div>
                          </div>
                          <div class="col-md-6" id="followUpField" style="display:none;">
                              <div class="form-group mb-3">
                                  <label for="followUpDate" class="control-label">Follow Up Date</label>
                                  <input type="date" name="follow_up_date" id="followUpDate" class="form-control" min="<?php echo date('Y-m-d'); ?>">
                              </div>
                          </div>
                          <div class="col-md-12" id="reasonField" style="display:none;">
                              <div class="form-group mb-3">
                                  <label for="reason" class="control-label">Reason</label>
                                  <textarea class="form-control" name="reason" id="reason" placeholder="Reason..."></textarea>
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
      // Dynamic fields in modal by status
      document.addEventListener('DOMContentLoaded', function () {
        const statusSelect = document.getElementById('newStatus');
        const additionalFeesField = document.getElementById('additionalFeesField');
        const followUpField = document.getElementById('followUpField');
        const reasonField = document.getElementById('reasonField');

        const feesInput = additionalFeesField.querySelector('input[name="fees"]');
        const followUpDateInput = followUpField.querySelector('input[name="follow_up_date"]');
        const reasonTextarea = reasonField.querySelector('textarea[name="reason"]');

        const updateFieldVisibility = () => {
          const v = statusSelect.value;

          additionalFeesField.style.display = 'none';
          followUpField.style.display = 'none';
          reasonField.style.display = 'none';

          feesInput.required = false;
          followUpDateInput.required = false;
          reasonTextarea.required = false;

          if (v === '0') {
            reasonField.style.display = 'block';
            reasonTextarea.required = true;
          } else if (v === '1') {
            additionalFeesField.style.display = 'block';
            feesInput.required = true;
          } else if (v === '2') {
            followUpField.style.display = 'block';
            followUpDateInput.required = true;
          }
        };

        statusSelect.addEventListener('change', updateFieldVisibility);
        updateFieldVisibility();
      });

      // AJAX save for status update (requires status_update.php)
      document.getElementById('saveChanges').addEventListener('click', function () {
        const formData = new FormData(document.getElementById('updateForm'));

        fetch('status_update.php', {
          method: 'POST',
          body: formData,
        })
        .then(r => r.json())
        .then(data => {
          if (data.success) {
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('viewModal'));
            modal.hide();
            document.querySelector('.modal-backdrop')?.remove();
            alert('Data updated successfully!');
            window.location.reload();
          } else {
            alert('Error: ' + (data.error || 'Unknown error'));
          }
        })
        .catch(err => {
          console.error(err);
          alert('An error occurred. Please try again.');
        });
      });
    </script>
    
</body>
</html>
