<?php include("includes/config.php"); ?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <?php include_once("seo.php");?>
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">
  <link rel="manifest" href="assets/img/favicons/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/fontawesome.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
  <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
<style>
  .form-control:disabled, .form-control[readonly] {
    background-color: #ffffff;
    opacity: 1;
}
</style>
</head>

<body>

  <?php include("header.php") ?>

  <!-- <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/breadcrumb.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title text-white">Book Appointment</h1>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Book Appointment</li>
                </ul>
            </div>
        </div>
    </div> -->

  <div class="space pb-0 appointment">
    <div class="container">
   <form action="save_contact.php" method="post" onsubmit="return validateForm();" class="contact-form" data-bg-src="assets/scan-world/book-appointment.png">
  <div class="input-wrap">
    <h2 class="sec-title">Book Appointment</h2>
    <div class="row">

      <div class="form-group col-12">
        <input type="text" class="form-control" name="name" placeholder="Your Name" required>
        <i class="fal fa-user"></i>
      </div>

      <div class="form-group col-12">
        <input type="text" class="form-control" name="phone" placeholder="Phone Number" required pattern="[1-9]{1}[0-9]{9}">
        <i class="fal fa-phone"></i>
      </div>

      <!-- Select Center -->
      <div class="form-group col-6">
        <select name="branch" class="form-select" required>
          <option value="" disabled selected hidden>Select Center</option>
          <option value="1">Nandanam</option>
          <option value="2">Nanganallur</option>
          <option value="3">Aminjikarai</option>
        </select>
        <i class="fal fa-chevron-down"></i>
      </div>

      <!-- Select Service -->
      <div class="form-group col-6">
        <select name="service" class="form-select" required>
          <option value="" disabled selected hidden>Select Service</option>
          <option value="1">MRI</option>
          <option value="2">CT</option>
          <option value="3">X-Ray</option>
          <option value="4">ECG</option>
        </select>
        <i class="fal fa-chevron-down"></i>
      </div>

      <!-- Optional: Select Test -->
      <div class="form-group col-12">
        <select name="test_name" class="form-select" required>
          <option value="" disabled selected hidden>Select Test</option>
          <option value="Caution Deposit for CT/MRI">Caution Deposit for CT/MRI</option>
          <option value="3D CBCT with Report - 1 Segment">3D CBCT with Report - 1 Segment</option>
          <option value="2D Digital Ceph Lateral X-Ray">2D Digital Ceph Lateral X-Ray</option>
          <option value="Computerised ECG">Computerised ECG</option>
        </select>
        <i class="fal fa-chevron-down"></i>
      </div>

      <div class="form-group col-6">
       <input name="date" 
             type="text" 
             class="form-control" 
             id="bookingdate" 
             placeholder="Select Date*" 
             autocomplete="off" 
             required>
      </div>
      <script>
  // Prevent manual typing in the date field
  document.getElementById('bookingdate').setAttribute('readonly', 'readonly');

  // Initialize datepicker
  $('#bookingdate').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true,
    startDate: new Date(), // disable past dates
    daysOfWeekDisabled: [0] // disable Sundays
  }).on('changeDate', function (e) {
    var d = e.date;
    if (d.getDay() === 0) {
      alert('Bookings are not available on Sunday. Please choose a different date.');
      $(this).datepicker('clearDates');
    }
  });

  // ✅ Validation before form submission
  function validateForm() {
    var dateInput = document.getElementById('bookingdate');
    var dateVal = dateInput.value.trim();

    if (!dateVal) {
      alert('Please select a date before submitting.');
      dateInput.focus();
      return false;
    }
    return true;
  }
</script>

      <div class="form-group col-6">
        <input type="text" class="time-pick form-control" name="time" placeholder="Time" required>
      </div>

      <div class="form-btn col-12 mt-3">
        <button class="th-btn btn-fw" type="submit">Submit</button>
      </div>
    </div>
  </div>
</form>

    </div>
  </div>
  <section class="space">
    <div class="container">
      <!-- <div class="title-area text-center">
                <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="Icon">Work Process</span>
                <h2 class="sec-title">Seamless Scan Process for <br>Accurate Diagnosis</h2>
            </div> -->
      <div class="process-card-wrap">
        <div class="process-card">
          <div class="box-img">
            <div class="img">
              <img src="assets/scan-world/centers/step-1.webp" alt="icon">
            </div>
            <p class="box-number">01</p>
          </div>
          <h3 class="box-title">Book Appointment</h3>
          <p class="box-text">Schedule your scan at your convenience with a hassle-free booking process.</p>
        </div>
        <div class="process-card">
          <div class="box-img">
            <div class="img">
              <img src="assets/scan-world/centers/step-2.webp" alt="icon">
            </div>
            <p class="box-number">02</p>
          </div>
          <h3 class="box-title">Undergo Scan</h3>
          <p class="box-text">Experience high-quality imaging with advanced scanning technology.</p>
        </div>
        <div class="process-card">
          <div class="box-img">
            <div class="img">
              <img src="assets/scan-world/centers/step-3.webp" alt="icon">
            </div>
            <p class="box-number">03</p>
          </div>
          <h3 class="box-title">Receive Report</h3>
          <p class="box-text">Get precise and detailed <br>reports analyzed by <br>experts.</p>
        </div>
        <div class="process-card">
          <div class="box-img">
            <div class="img">
              <img src="assets/scan-world/centers/step-4.webp" alt="icon">
            </div>
            <p class="box-number">04</p>
          </div>
          <h3 class="box-title">Ongoing Care</h3>
          <p class="box-text">Advanced imaging for precise diagnosis and<br> care.</p>
        </div>
      </div>
    </div>
  </section>
  <?php include("footer.php") ?>
  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
    </svg>
  </div>


<!-- jQuery FIRST -->
<script src="assets/js/vendor/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS (pick ONE; remove other bootstrap.js to avoid conflicts) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>

<!-- Bootstrap Datepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Initialize Datepicker -->
<script>
  // Optional: prevent manual typing so users can't type past dates
  document.getElementById('bookingdate').setAttribute('readonly', 'readonly');

  $('#bookingdate').datepicker({
    format: 'yyyy-mm-dd',   // consistent backend format
    autoclose: true,        // close after pick
    todayHighlight: true,   // highlight today
    startDate: new Date(),  // 🚫 disables all past dates
    daysOfWeekDisabled: [0] // 🚫 disable Sundays (0 = Sunday)
  }).on('changeDate', function (e) {
    // Extra guard if someone manages to inject a Sunday
    var d = e.date;
    if (d.getDay() === 0) {
      alert('Bookings are not available on Sunday. Please choose a different date.');
      $(this).datepicker('clearDate'); // correct method name for v1.9
    }
  });
</script>

<!-- Your other plugins/scripts AFTER the picker init -->
<script src="assets/js/swiper-bundle.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> <!-- REMOVE this if it conflicts; keep only one Bootstrap JS -->
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.counterup.min.js"></script>
<script src="assets/js/jquery.ui.min.js"></script>
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>
<script src="assets/js/main.js"></script>


</html>