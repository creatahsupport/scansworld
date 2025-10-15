<?php

include("../includes/config.php"); 
include_once("include/header.php");
$sql = "SELECT ba.status as status_bar,b.branch_name,s.service_name,ba.* FROM book_appointment as ba left join branch as b on b.id=ba.branch left join service as s on s.id=ba.service where ba.status=2 order by ba.id desc";
// print_r($sql);die;
$result = $con->query($sql);
?>
<!doctype html>
<html lang="en">
<head>
<title>Followup Report | Scans World</title>
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
                  <h2 class="mb-0">Followup Report</h2>
                </div>
              </div>
              
            </div>
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
                                                <th>Id</th>
                                                <th>Patient Name</th>
                                  
                                                <th>Phone</th>
                                                <th>Branch</th>
                                                <th>Service</th>
                                                <th>Appointment Date</th>
                                                <th>Appointment Time</th>
                                                <th>Status</th>
                                                <th>Followup Date</th>
                                                <th>Action</th>
                                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          if ($result->num_rows > 0) {
                              while ($row = $result->fetch_assoc()) {
                          ?>
                               <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['patient_name']; ?></td>
                                                  
                                                    <td><?php echo $row['phone']; ?></td>
                                                    <td><?php echo $row['branch_name']; ?></td>
                                                    <td><?php echo $row['service_name']; ?></td>
                                                    <td><?php echo date("d-m-Y", strtotime($row['appointment_date'])); ?></td>
                                                    <td><?php echo date("h:i A", strtotime($row['appointment_time'])); ?></td>
                                                    
                                                    <td>
                                                        <?php
                                                        $status = $row['status_bar'];
                                                        if ($status == 0) {
                                                            echo "Not Turned";
                                                        } elseif ($status == 1) {
                                                            echo "Turned";
                                                        } elseif ($status == 2) {
                                                            echo "Follow-Up";
                                                        } else {
                                                            echo "Unknown"; // For unexpected values
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="padding-left: 56px;">
                                                        <?php
                                                        echo !empty($row['follow_up_date']) ? date("d-m-Y", strtotime($row['follow_up_date'])) : "-";
                                                        ?>
                                                    </td>

                                                    <td>
                                                    <?php if ($row['status'] == 0 || $row['status'] == 2): ?>
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-info" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#viewModal" 
                                                            data-id="<?php echo $row['id']; ?>" 
                                                            onclick="loadAppointmentDetails(this)">
                                                            View
                                                        </button>
                                                    <?php else: ?>
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-secondary" 
                                                            disabled>
                                                            Closed
                                                        </button>
                                                    <?php endif; ?>
                                                </td>
                                                </tr>
                          <?php
                              }
                          }
                          ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  </div>
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
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="additionalFeesField" style="display: none;">
                                <div class="form-group mb-3">
                                    <label for="fees" class="control-label">Additional Fees</label>
                                    <input type="text" name="fees" id="fees" class="form-control">
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

                // Set the enquiry date fields as required and visible
                enquiryDateInput.required = true;
                enquiryToDateInput.required = true;

                appointmentDateInput.required = false;
                appointmentToDateInput.required = false;
            } else if (this.value === 'appointment') {
                enquiryDiv.style.display = 'none';
                enquiryToDiv.style.display = 'none';
                appointmentDiv.style.display = 'block';
                appointmentToDiv.style.display = 'block';

                // Set the appointment date fields as required and visible
                appointmentDateInput.required = true;
                appointmentToDateInput.required = true;

                enquiryDateInput.required = false;
                enquiryToDateInput.required = false;
            }
        });
        selectData.dispatchEvent(new Event('change'));
    });
</script>
<script>
   document.getElementById('saveChanges').addEventListener('click', function () {
    // Gather form data
    const formData = new FormData(document.getElementById('updateForm'));

    // Send AJAX request
    fetch('status_update.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json()) // Parse JSON response
        .then(data => {
            if (data.success) {
                // Close the modal
                const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('viewModal'));
                modal.hide();

                // Ensure the backdrop is removed
                document.querySelector('.modal-backdrop')?.remove();

                // Optionally show a success message
                alert('Data updated successfully!');
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
});


    function loadAppointmentDetails(button) {
    // Get the appointment ID from the button's data-id attribute
    const appointmentId = button.getAttribute('data-id');

    // Set the value of the hidden input inside the modal
    document.getElementById('appointmentId').value = appointmentId;

    // Optional: Add other logic to load additional details via AJAX if needed
}
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.getElementById('newStatus'); // Updated ID
    const additionalFeesField = document.getElementById('additionalFeesField');
    const followUpField = document.getElementById('followUpField');
    const reasonField = document.getElementById('reasonField');
    
    // Input elements within each field
    const feesInput = additionalFeesField.querySelector('input[name="fees"]');
    const followUpDateInput = followUpField.querySelector('input[name="follow_up_date"]');
    const reasonTextarea = reasonField.querySelector('textarea[name="reason"]');

    // Function to update visibility of fields and manage 'required' attribute based on selected status
    const updateFieldVisibility = () => {
        const selectedValue = statusSelect.value;

        // Hide all fields initially and remove 'required' attributes
        additionalFeesField.style.display = 'none';
        feesInput.required = false;
        
        followUpField.style.display = 'none';
        followUpDateInput.required = false;
        
        reasonField.style.display = 'none';
        reasonTextarea.required = false;

        // Show fields based on selected status and add 'required' where needed
        if (selectedValue === '0') {
            reasonField.style.display = 'block';
            reasonTextarea.required = true;
        } else if (selectedValue === '1') {
            additionalFeesField.style.display = 'block';
            feesInput.required = true;
        } else if (selectedValue === '2') {
            followUpField.style.display = 'block';
            followUpDateInput.required = true;
        }
    };

    // Attach event listener to the status select dropdown
    statusSelect.addEventListener('change', updateFieldVisibility);

    // Call the function to set initial visibility and required attributes based on the default selected value
    updateFieldVisibility();
});
</script>
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
        perPage: 10
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
