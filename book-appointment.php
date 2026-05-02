<?php include("includes/config.php");

$testimonial_query = "SELECT * FROM testimonial WHERE del_i = 0 ORDER BY id DESC LIMIT 50";
$latest_testimonial = mysqli_query($con, $testimonial_query);
?>

<!doctype html>
<html class="no-js" lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <?php include_once("seo.php"); ?>

  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="57x57" href="assets/img/favicons/favicon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/img/favicons/favicon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/img/favicons/favicon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/favicons/favicon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/img/favicons/favicon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/img/favicons/favicon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/img/favicons/favicon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/img/favicons/favicon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/img/favicons/favicon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/img/favicons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicons/favicon-16x16.png">

  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/img/favicons/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/fontawesome.min.css">
  <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
  <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
  <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Cloudflare Turnstile -->
  <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
  <style>
    .form-control:disabled,
    .form-control[readonly] {
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
      <form action="save_contact.php" method="post" onsubmit="return validateForm();" class="contact-form"
        data-bg-src="assets/scan-world/book-appointment.png">
        <div class="input-wrap">
          <h2 class="sec-title">Book Appointment</h2>
          <div class="row">

            <div class="form-group col-12">
              <input type="text" class="form-control" name="name" placeholder="Your Name" required minlength="3"
                maxlength="50" oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '');"
                title="Letters and spaces only.">
              <i class="fal fa-user"></i>
            </div>

            <div class="form-group col-12">
              <input type="text" class="form-control" name="phone" placeholder="Phone Number" required
                inputmode="numeric" pattern="[1-9][0-9]{9}" maxlength="10" title="Enter exactly 10 digits."
                onkeydown="if(event.key.length===1 && !/[0-9]/.test(event.key)) event.preventDefault();"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
              <i class="fal fa-phone"></i>
            </div>

            <!-- Select Center -->
            <div class="form-group col-12">
              <select name="branch" class="form-select" required>
                <option value="" disabled selected hidden>Select Center</option>
                <option value="1">Nandanam</option>
                <option value="2">Nanganallur</option>
                <option value="3">Aminjikarai</option>
              </select>
              <i class="fal fa-chevron-down"></i>
            </div>

            <!-- Select Service -->
            <div class="form-group col-12">
              <select name="service" class="form-select" required>
                <option value="" disabled selected hidden>Select Service</option>
                <option value="1">Wide Bore 3 Tesla MRI Scan</option>
                <option value="2">MRI Scan</option>
                <option value="3">X-Ray</option>
                <option value="4">ECG</option>
                <option value="5">CT Scan</option>
                <option value="6">PET - CT Scan</option>
              </select>
              <i class="fal fa-chevron-down"></i>
            </div>

            <!-- Optional: Select Test -->
            <!-- <div class="form-group col-12">
        <select name="test_name" class="form-select" required>
          <option value="" disabled selected hidden>Select Test</option>
          <option value="Caution Deposit for CT/MRI">Caution Deposit for CT/MRI</option>
          <option value="3D CBCT with Report - 1 Segment">3D CBCT with Report - 1 Segment</option>
          <option value="2D Digital Ceph Lateral X-Ray">2D Digital Ceph Lateral X-Ray</option>
          <option value="Computerised ECG">Computerised ECG</option>
        </select>
        <i class="fal fa-chevron-down"></i>
      </div> -->

            <div class="form-group col-12">
              <input name="date" type="text" class="form-control" id="bookingdate" placeholder="Select Date*"
                autocomplete="off" required>
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

            <div class="form-group col-12">
              <select name="time" id="timeSlot" class="form-select" required>
                <option value="" disabled selected hidden>Select Time</option>
                <option value="07:30 AM">07:30 AM</option>
                <option value="08:00 AM">08:00 AM</option>
                <option value="08:30 AM">08:30 AM</option>
                <option value="09:00 AM">09:00 AM</option>
                <option value="09:30 AM">09:30 AM</option>
                <option value="10:00 AM">10:00 AM</option>
                <option value="10:30 AM">10:30 AM</option>
                <option value="11:00 AM">11:00 AM</option>
                <option value="11:30 AM">11:30 AM</option>
                <option value="12:00 PM">12:00 PM</option>
                <option value="12:30 PM">12:30 PM</option>
                <option value="01:00 PM">01:00 PM</option>
                <option value="01:30 PM">01:30 PM</option>
                <option value="02:00 PM">02:00 PM</option>
                <option value="02:30 PM">02:30 PM</option>
                <option value="03:00 PM">03:00 PM</option>
                <option value="03:30 PM">03:30 PM</option>
                <option value="04:00 PM">04:00 PM</option>
                <option value="04:30 PM">04:30 PM</option>
                <option value="05:00 PM">05:00 PM</option>
                <option value="05:30 PM">05:30 PM</option>
                <option value="06:00 PM">06:00 PM</option>
                <option value="06:30 PM">06:30 PM</option>
                <option value="07:00 PM">07:00 PM</option>
                <option value="07:30 PM">07:30 PM</option>
                <option value="08:00 PM">08:00 PM</option>
                <option value="08:30 PM">08:30 PM</option>
                <option value="09:00 PM">09:00 PM</option>
                <option value="09:30 PM">09:30 PM</option>
                <option value="10:00 PM">10:00 PM</option>
                <option value="10:30 PM">10:30 PM</option>
              </select>

            </div>
            <input type="hidden" name="utm_source" id="utm_source">
            <input type="hidden" name="utm_medium" id="utm_medium">
            <input type="hidden" name="utm_campaign" id="utm_campaign">
            <input type="hidden" name="utm_term" id="utm_term">
            <input type="hidden" name="utm_content" id="utm_content">
            <div class="form-btn col-12 mt-3 text-center">
              <div class="cf-turnstile d-inline-block" data-sitekey="<?php echo $cloudflare_site_key; ?>"
                style="margin-top: 15px; margin-bottom: 15px;"></div>
              <button class="th-btn btn-fw mt-3" type="submit">Submit</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>
  <section class="overflow-hidden bg-smoke space" id="service-sec"
    data-bg-src="assets/scan-world/home/service_bg_1.webp">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="title-area text-center">
            <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="Icon">Our Services</span>
            <h2 class="sec-title">Scans & Blood Tests</h2>
          </div>
        </div>
      </div>
      <div class="row gy-4 justify-content-center">
        <div class="container">
          <div class="row">
            <div class="col-md-3 col-sm-6 col-6">
              <a href="mri-scan">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/wine-barrel.png" alt="icon">
                  </div>
                  <div class="media-body text-start text-start">
                    <h3 class="box-title">MRI</h3>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6">
              <a href="pet-ct">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/ct-scan.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">PET CT</h3>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6">
              <a href="160-slice-cardiac-ct">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/heart-attack.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">160 Slice Cardiac CT</h3>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6">
              <a href="gamma-camera">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/ct-scan.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">Nuclear Scans</h3>
                  </div>
                </div>
              </a>
            </div>

          </div>
          <div class="row">
            <div class="col-md-3 col-sm-6 col-6">
              <a href="multislice-ct-scan">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/brain-imaging.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">Multislice CT Scan</h3>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-3 col-sm-6 col-6">
              <a href="digital-mammography">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/ultrasound.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">Digital Mammography</h3>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6">
              <a href="color-doppler">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/meters.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">Color Doppler</h3>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6">
              <a href="echo">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/radiotherapy.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">ECHO</h3>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-3 col-sm-6 col-6">
              <a href="eeg">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/monitor.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">EEG</h3>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6">
              <a href="eeg">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/eeg.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">EEG & TMT</h3>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6">
              <a href="dexa">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/bone.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">DEXA</h3>
                  </div>
                </div>
              </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6">
              <a href="digital-xray">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/clinic.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">Digital X-Ray</h3>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-3 col-sm-6 col-6">
              <a href="opg">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/mammography.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">OPG</h3>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-3 col-sm-6 col-6">
              <a href="colonoscopy-and-endoscopy">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/show.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">Endoscopy / Colonoscopy</h3>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-3 col-sm-6 col-6">
              <a href="fnac">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/endoscopy.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">FNAC</h3>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-md-3 col-sm-6 col-6">
              <a href="automated-laboratory">
                <div class="feature-box text-center">
                  <div class="box-icon">
                    <img src="assets/scan-world/service-icon/measuring-device.png" alt="icon">
                  </div>
                  <div class="media-body text-start">
                    <h3 class="box-title">Automated Laboratory</h3>
                  </div>
                </div>
              </a>
            </div>



          </div>

        </div>

      </div>
  </section>

  <section class="space" id="testi-sec">
    <div class="container">
      <div class="title-area text-center">
        <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Testimonials</span>
        <h2 class="sec-title">What Our Patients Say?</h2>
      </div>
      <div class="swiper th-slider" id="testiSlide1"
        data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"2"}}}'>
        <div class="swiper-wrapper">
          <?php if (!empty($latest_testimonial)) { ?>
            <?php foreach ($latest_testimonial as $testimonial) { ?>
              <div class="swiper-slide">
                <div class="testi-card bg-smoke">
                  <div class="box-review">
                    <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i
                      class="fa-sharp fa-solid fa-star"></i>
                  </div>
                  <div class="box-quote">
                    <img src="assets/img/icon/quote_1.svg" alt="Icon">
                  </div>
                  <p class="box-text"><?php
                  $content = htmlspecialchars($testimonial['content']);
                  $shortened_content = mb_substr($content, 0, 200); // Change 100 to your desired character limit
                  echo $shortened_content . (strlen($content) > 200 ? '...' : ''); ?></p>
                  <div class="box-profile">
                    <div class="box-img">
                      <img src="assets/scan-world/testimonial.png" alt="Avater">
                    </div>
                    <div class="box-content">
                      <h3 class="box-title"><?php echo htmlspecialchars($testimonial["title"]); ?></h3>

                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
          <?php } else { ?>
            <p class="text-center w-100">No testimonials available at the moment.</p>
          <?php } ?>
        </div>
        <div class="slider-pagination"></div>
      </div>
    </div>
  </section>
  <?php include("footer.php") ?>
  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
        style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
      </path>
    </svg>
  </div>


  <!-- jQuery FIRST -->
  <script src="assets/js/vendor/jquery-3.7.1.min.js"></script>

  <!-- Bootstrap JS (pick ONE; remove other bootstrap.js to avoid conflicts) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>

  <!-- Bootstrap Datepicker JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
  <script>
    function getUTM(param) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(param);
    }

    document.getElementById('utm_source').value = getUTM('utm_source');
    document.getElementById('utm_medium').value = getUTM('utm_medium');
    document.getElementById('utm_campaign').value = getUTM('utm_campaign');
    document.getElementById('utm_term').value = getUTM('utm_term');
    document.getElementById('utm_content').value = getUTM('utm_content');
  </script>
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
  <script>
    // Hide past time slots if today is selected and time has passed (e.g., after 10AM)
    function hidePastTimes() {
      const dateInput = document.getElementById('bookingdate');
      const timeSelect = document.getElementById('timeSlot');
      const now = new Date();
      const selectedDate = new Date(dateInput.value);
      const isToday = selectedDate.toDateString() === now.toDateString();

      // Make all options visible again
      for (let opt of timeSelect.options) opt.hidden = false;

      if (isToday) {
        const currentMinutes = now.getHours() * 60 + now.getMinutes(); // current time in minutes

        // Loop through every time option
        for (let opt of timeSelect.options) {
          if (!opt.value) continue; // skip placeholder
          const [t, mer] = opt.value.split(' ');
          let [h, m] = t.split(':').map(Number);

          // Convert to 24-hour format
          if (mer === 'PM' && h !== 12) h += 12;
          if (mer === 'AM' && h === 12) h = 0;
          const totalMinutes = h * 60 + m;

          // Hide if this time has already passed
          if (totalMinutes <= currentMinutes) {
            opt.hidden = true;
          }
        }

        // If user opens form after 10:00 PM, all slots will be hidden
        // so we can show a fallback message
        const visibleOptions = [...timeSelect.options].filter(o => !o.hidden && o.value);
        if (visibleOptions.length === 0) {
          const msg = document.createElement('option');
          msg.textContent = 'No slots available today';
          msg.disabled = true;
          timeSelect.appendChild(msg);
        }
      }
    }

    // Trigger the function when the date changes
    $('#bookingdate').on('changeDate', hidePastTimes);

    // Also run on page load in case today's date is prefilled
    document.addEventListener('DOMContentLoaded', hidePastTimes);
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