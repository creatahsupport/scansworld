<?php include("dashboard_query.php"); ?>
<!doctype html>
<html lang="en">
<head>
  <title>Dashboard | Scans World</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="description" content="Scans World" />
  <meta name="author" content="Scans World" />
  <link rel="icon" href="<?php echo $favicon ?? 'assets/img/favicon.png'; ?>" type="image/x-icon" />
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme="light">
  <div class="loader-bg">
    <div class="loader-track"><div class="loader-fill"></div></div>
  </div>

  <?php include("include/sidebar.php"); ?>

  <div class="pc-container">
    <div class="pc-content">

      <!-- Page Header -->
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

      <!-- Statistics Cards -->
      <div class="row">
        <!-- Total Appointments -->
        <div class="col-md-4 col-sm-6">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <h5 class="mb-4">Total Book Appointments</h5>
              <h3 class="f-w-300 d-flex align-items-center m-b-0">
                <?php echo $book_appointment_count ?? 0; ?>
              </h3>
            </div>
          </div>
        </div>

        <!-- Total Blogs -->
        <div class="col-md-4 col-sm-6">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <h5 class="mb-4">Total Blogs</h5>
             <h3 class="f-w-300 d-flex align-items-center m-b-0">
  <?php echo $total_blog_count ?? 0; ?>
</h3>

            </div>
          </div>
        </div>

        <!-- Total Doctors -->
        <div class="col-md-4 col-sm-6">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <h5 class="mb-4">Total Doctors Count</h5>
                      <h3 class="f-w-300 d-flex align-items-center m-b-0">
  <?php echo $total_doctor_count ?? 0; ?>
</h3>
            </div>
          </div>
        </div>

        <!-- News & Events -->
        <!-- <div class="col-md-4 col-sm-6">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <h5 class="mb-4">Total News & Events Count</h5>
                      <h3 class="f-w-300 d-flex align-items-center m-b-0">
  <?php echo $total_news_count ?? 0; ?>
</h3>
            </div>
          </div>
        </div> -->

        <!-- Today's Appointments Summary -->
        <!-- <div class="col-md-8 col-sm-6">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <h5 class="mb-4">Today's Appointments Summary</h5>
              <div class="d-flex align-items-center mt-3">
                <h6 class="me-2">Total:</h6>
                <h5 class="me-4"><?php echo $today_booking_count ?? 0; ?></h5>
                <h6 class="me-2">Turned:</h6>
                <h5 class="me-4 text-success"><?php echo $today_turned ?? 0; ?></h5>
                <h6 class="me-2">Not Turned:</h6>
                <h5 class="text-danger"><?php echo $today_not_turned ?? 0; ?></h5>
              </div>
            </div>
          </div>
        </div> -->

        <!-- Total Revenue -->
        <!-- <div class="col-md-4 col-sm-6">
          <div class="card statistics-card-1 overflow-hidden">
            <div class="card-body">
              <h5 class="mb-4">Total Revenue</h5>
              <h3 class="f-w-300 d-flex align-items-center m-b-0">₹<?php echo number_format($total_fees ?? 0, 2); ?></h3>
            </div>
          </div>
        </div> -->

        <!-- Branch-wise Chart -->
        <!-- <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5>Branch-wise Appointment Overview (Last 6 Months)</h5>
            </div>
            <div class="card-body" style="height: 460px;">
              <canvas id="branchChart"></canvas>
            </div>
          </div>
        </div> -->

      </div><!-- /.row -->

    </div>
  </div>

  <?php include("include/footer.php"); ?>

  <!-- Chart.js -->
  <script>
    const labels = <?php echo $labels_json ?? '[]'; ?>;
    const data = <?php echo $data_json ?? '[]'; ?>;

    if (labels.length > 0 && data.length > 0) {
      const ctx = document.getElementById('branchChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Appointments',
            data: data,
            backgroundColor: [
              '#FF851F', '#1C45A5', '#142D56', '#4BC0C0', '#FF9F40', '#C4A3FF'
            ]
          }]
        },
        options: {
          responsive: true,
          scales: { y: { beginAtZero: true } },
          plugins: {
            legend: { position: 'top' },
            tooltip: {
              callbacks: {
                label: function(context) {
                  return context.label + ': ' + context.parsed.y + ' appointments';
                }
              }
            }
          }
        }
      });
    }
  </script>

  <!-- JS Libraries -->
  <script src="assets/js/plugins/popper.min.js"></script>
  <script src="assets/js/plugins/simplebar.min.js"></script>
  <script src="assets/js/plugins/bootstrap.min.js"></script>
  <script src="assets/js/fonts/custom-font.js"></script>
  <script src="assets/js/pcoded.js"></script>
  <script src="assets/js/plugins/feather.min.js"></script>
</body>
</html>
