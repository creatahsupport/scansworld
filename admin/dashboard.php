<?php include("dashboard_query.php") ?>
<!doctype html>
<html lang="en">
<head>
    <title>Dashboard | Scans World</title>
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
    <!-- ApexCharts library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                  <h2 class="mb-0">Scans World Dashboard</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- <h5>Book Appointment </h5> -->
        <div class="row">
          <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
              <div class="card-body">
                <h5 class="mb-4">Total Book Appointments</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0"><?php echo $book_appointment_count; ?></h3>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="col-md-8 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
              <div class="card-body">
                <h5 class="mb-4">Today Book Appointments</h5>
                <div class="d-flex align-items-center mt-3">
                <h6 style="padding-top: 6px;">Total : </h6>
                  <h5 class="f-w-300 d-flex align-items-center m-b-0"> <?php echo $today_booking_count; ?></h5>
                  &nbsp;&nbsp;<h6 style="padding-top: 6px;">Turned : </h6>
                  <h5 class="f-w-300 d-flex align-items-center m-b-0"> <?php echo $today_turned; ?></h5>
                  &nbsp;&nbsp;<h6 style="padding-top: 6px;">Not Turned: </h6>
                  <h5 class="f-w-300 d-flex align-items-center m-b-0"> <?php echo $today_not_turned; ?></h5>
                </div>
              </div>
            </div>
          </div> -->
          <!-- <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
              <div class="card-body">
                <h5 class="mb-2">Total revenue</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0"><?php echo $total_fees; ?></h3>
                </div>
              </div>
            </div>
          </div> -->
          <!-- <h5>Video Appointment</h5>
          <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
              <div class="card-body">
                <h5 class="mb-2">Total Video Appointments</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">0</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
              <div class="card-body">
                <h5 class="mb-2">Today Video Appointments</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">0</h3>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="card statistics-card-1 overflow-hidden">
              <div class="card-body">
                <h5 class="mb-2">Total revenue</h5>
                <div class="d-flex align-items-center mt-3">
                  <h3 class="f-w-300 d-flex align-items-center m-b-0">0</h3>
                </div>
              </div>
            </div>
          </div> -->
          <!-- <div class="col-md-12">
            <div class="card">
            <div class="card-header">
                <h5>Book Appointment</h5>
            </div>
            <div class="card-body" style="height: 460px;">
                <canvas id="pie-chart-1"></canvas>
            </div>
          </div> -->
        </div>
          <!-- <div class="col-md-6 col-xl-6">
            <div class="card">
            <div class="card-header">
                <h5>Video Appointment</h5>
            </div>
            <div class="card-body" style="height: 460px;">
                <canvas id="pie-chart-2"></canvas>
            </div>
            </div> -->
          </div>
 

          
          

          </div>
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </div>
    <?php include("include/footer.php");?> 
    <!-- [ Main Content ] end -->
    <script>
  // Use your existing labels and data from PHP
  var labels = <?php echo $labels_json; ?>;
  var data = <?php echo $data_json; ?>;

  // Get the 2D context of your canvas element
  var ctx = document.getElementById('pie-chart-1').getContext('2d');

  // Create the Bar chart
  var barChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels, // Branch names
      datasets: [{
        label: 'Appointments',
        data: data,    // Appointment counts
        backgroundColor: [
          '#ff851f', '#1c45a5', '#142d56', '#4BC0C0', '#FF9F40', '#C4A3FF'
        ],
        hoverBackgroundColor: [
          '#ff851f', '#1c45a5', '#142d56', '#4BC0C0', '#FF9F40', '#C4A3FF'
        ]
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true // Ensure the Y-axis starts at 0
        }
      },
      plugins: {
        legend: {
          position: 'top'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              // For bar charts, the value is in context.parsed.y
              return context.label + ': ' + context.parsed.y;
            }
          }
        }
      }
    }
  });
</script>

    <script src="assets/js/plugins/apexcharts.min.js"></script>
    <script src="assets/js/plugins/jsvectormap.min.js"></script>
    <script src="assets/js/plugins/world.js"></script>
    <script src="assets/js/plugins/world-merc.js"></script>
    <script src="assets/js/pages/dashboard-default.js"></script>
    <script src="assets/js/plugins/popper.min.js"></script>
    <script src="assets/js/plugins/simplebar.min.js"></script>
    <script src="assets/js/plugins/bootstrap.min.js"></script>
    <script src="assets/js/fonts/custom-font.js"></script>
    <script src="assets/js/pcoded.js"></script>
    <script src="assets/js/plugins/feather.min.js"></script>
    <script src="assets/js/pages/chart-apex.js"></script>
  </body>
</html>
