
<?php include("includes/config.php"); ?>

<?php  

require_once("mail/mail.php"); 

if(isset($_POST['submit_flag'])) {
    $b_name = $_POST['name'];
    $b_mail = $_POST["email"];
    $b_phone = $_POST["phone"];
    $be_package = $_POST['package'];

    $subject = "New Enquiry - Request Callback";
    $admin_msg = "<p>Dear Admin,</p>
    <p>You have received a request callback enquiry. Please check the details below:</p>
    <p>Name: ".$b_name."</p>
    <p>Email: ".$b_mail."</p>
    <p>Phone: ".$b_phone."</p>
    <p>Package: ".$be_package."</p>";

    // Send email
    mailer($subject, $admin_msg, $To_email);

    echo "<script>
    setTimeout(function() {
        window.location.href = 'packages-thankyou';
    }, 2000);
</script>";
exit();

}
?>

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
  <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">
  <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
  <?php include 'header.php'; ?>

  <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/breadcrumb.png">
    <div class="container">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title text-white">Master Health Checkup Packages</h1>
        <ul class="breadcumb-menu">
          <li><a href="home-medical-clinic.html" class="text-white">Home</a></li>
          <li>Master Health Checkup</li>
        </ul>
      </div>
    </div>
  </div>

  <!-- <section class="space pb-0 pt-5">
    <div class="container z-index-common">
      <div class="th-comment-form " style="background: #d4efff">
        <div class="form-title">
          <h3 class="blog-inner-title h4 mb-2"><i class="fa-solid fa-reply"></i> Book Your Package</h3>

        </div>
        <div class="row">
          <div class="col-md-3 form-group">
            <input type="text" placeholder="Your Name*" class="form-control">
            <i class="far fa-user"></i>
          </div>
          <div class="col-md-3 form-group">
            <input type="text" placeholder="Your Email*" class="form-control">
            <i class="far fa-envelope"></i>
          </div>
          <div class="col-md-3 form-group">
            <input type="text" placeholder="Phone Number*" class="form-control">
            <i class="far fa-phone"></i>
          </div>
          <div class="col-md-3 form-group">
            <select class="form-control" required>
              <option value="" disabled selected>Select Package*</option>
              <option value="basic">Basic Package</option>
              <option value="standard">Standard Package</option>
              <option value="premium">Premium Package</option>
            </select>

          </div>

          <div class="col-12 form-group mb-0 text-center">
            <button class="th-btn">Book Now</button>
          </div>
        </div>
      </div>
    </div>
  </section> -->

  <section class="space">
    <div class="container z-index-common">
      <div class="row gy-30 justify-content-center">

        <div class="col-xl-4 col-md-6">
          <div class="offer-card mega-hover">
            <!-- Title (Fixed) -->
            <h3 class="box-title pop">Basic Master Health Check</h3>
            <!-- Scrollable Content -->
            <div class="package-content">
              <p class="text-dark">CBC, FBS, PPBS, Urea, Creatinine, Total Cholesterol, Urine Analysis, Stool Analysis, Digital X-ray chest, Computerized ECG, USG Whole Abdomen (Screening).</p>
            </div>
            <!-- Price & Button (Fixed) -->
            <div class="price-btn">
            <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Basic Master Health Check">Book Now</a>
              <span class="h6 box-subtitle">₹ 1750</span>
            </div>
          </div>
        </div>

        <div class="col-xl-4 col-md-6">
          <div class="offer-card mega-hover">
            <!-- Title (Fixed) -->
            <h3 class="box-title pop">Vitalmaster Health Check</h3>
            <!-- Scrollable Content -->
            <div class="package-content">
              <p class="text-dark">CBC,FBS,PPBS,LIPIDPROFILE,LFT,Urea, Creatinine, UrineAnalysis, StoolAnalysis, DigitalX-ray-chest,computerized-ECG, USG Whole Abdomen,
              Complimentary breakfast, physician consultation.</p>
            </div>
            <!-- Price & Button (Fixed) -->
            <div class="price-btn">
            <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Basic Master Health Check">Book Now</a>
              <span class="h6 box-subtitle">₹ 5000 </span>
            </div>
          </div>
        </div>
       

        <div class="col-xl-4 col-md-6">
                <div class="offer-card mega-hover">
                    <h3 class="box-title pop">Executive Master Health Check</h3>
                    <div class="package-content">
                        <p class="text-dark">CBC, FBS, PPBS, HbA1c, LIPID PROFILE, LFT, Urea, Creatinine, Uric Acid, Urine Analysis, Stool Analysis, Digital X-ray Chest, Computerized ECG, USG Whole Abdomen (Screening), PFT, Echo Cardiography, computerized Treadmill, PAP Smear, Liver elastogram (fibroscan), complimentary breakfast, physician consultation & physical examination.</p>
                    </div>
                    <div class="price-btn">
                        <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Executive Master Health Check">Book Now</a>
                        <span class="h6 box-subtitle">₹ 7000</span>
                    </div>
                </div>
            </div>

            <!-- Package 2 -->
            <div class="col-xl-4 col-md-6">
                <div class="offer-card mega-hover">
                    <h3 class="box-title pop">Basic Well Women Health Check</h3>
                    <div class="package-content">
                        <p class="text-dark">CBC, FBS, PPBS, HbA1c, Lipid profile, TSH, PAP Smear, Urine Analysis, Stool Analysis, Digital X-ray Chest, Computerized ECG, USG Whole Abdomen (Screening), complimentary breakfast, physician consultation & physical examination.</p>
                    </div>
                    <div class="price-btn">
                        <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Basic Well Women Health Check">Book Now</a>
                        <span class="h6 box-subtitle">₹ 4800</span>
                    </div>
                </div>
            </div>

            <!-- Package 3 -->
            <div class="col-xl-4 col-md-6">
                <div class="offer-card mega-hover">
                    <h3 class="box-title pop">Comprehensive Well Women Health Check</h3>
                    <div class="package-content">
                        <p class="text-dark">CBC, FBS, PPBS, HbA1c, Lipid profile, LFT, UREA, Creatinine, Uric Acid, Thyroid Function Test, PAP Smear, Urine Analysis, Stool Analysis, Digital X-ray Chest, Computerized ECG, USG Whole Abdomen, Sono Mammography, Digital Mammography, Liver elastogram (fibroscan), complimentary breakfast, physician consultation & physical examination, PFT.</p>
                    </div>
                    <div class="price-btn">
                        <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Comprehensive Well Women Health Check">Book Now</a>
                        <span class="h6 box-subtitle">₹ 6000</span>
                    </div>
                </div>
            </div>

            <!-- Package 4 -->
            <div class="col-xl-4 col-md-6">
                <div class="offer-card mega-hover">
                    <h3 class="box-title pop">Executive Well Women Health Check</h3>
                    <div class="package-content">
                        <p class="text-dark">CBC, FBS, PPBS, HbA1c, Lipid profile, LFT, UREA, Creatinine, Uric Acid, Thyroid Function Test: T3, T4, TSH, PAP Smear, Urine Analysis, Stool Analysis, Digital X-ray Chest, Computerized ECG, USG Whole Abdomen, Sono Mammography, Digital Mammography, ECHO Cardiography, Computerized Treadmill, Liver elastogram (fibroscan), complimentary breakfast, physician consultation, CA-125, CEA, Vit B12, Vit D3, prolactin, Estrogen, progesterone, calcium, phosphorus, iron, whole body bone density (DEXA), whole body fat analysis, PFT.</p>
                    </div>
                    <div class="price-btn">
                        <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Executive Well Women Health Check">Book Now</a>
                        <span class="h6 box-subtitle">₹ 12000</span>
                    </div>
                </div>
            </div>

            <!-- Package 5 -->
            <div class="col-xl-4 col-md-6">
                <div class="offer-card mega-hover">
                    <h3 class="box-title pop">Diabetic Profile I</h3>
                    <div class="package-content">
                        <p class="text-dark">CBC, FBS, PPBS, HbA1c, UREA, Creatinine, Cholesterol, Urine Analysis (routine), Computerized ECG.</p>
                    </div>
                    <div class="price-btn">
                        <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Diabetic Profile I">Book Now</a>
                        <span class="h6 box-subtitle">₹ 1200</span>
                    </div>
                </div>
            </div>

            <!-- Package 6 -->
            <div class="col-xl-4 col-md-6">
                <div class="offer-card mega-hover">
                    <h3 class="box-title pop">Diabetic Profile II</h3>
                    <div class="package-content">
                        <p class="text-dark">CBC, FBS, PPBS, UREA, Creatinine, Total Cholesterol, Urine Analysis, Thyroid Function Test, Urine Microalbumin, Computerized-ECG, Ophthalmic Consultation, Complimentary Breakfast.</p>
                    </div>
                    <div class="price-btn">
                        <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Diabetic Profile II">Book Now</a>
                        <span class="h6 box-subtitle">₹ 2500</span>
                    </div>
                </div>
            </div>

            <!-- Package 7 -->
            <div class="col-xl-4 col-md-6">
                <div class="offer-card mega-hover">
                    <h3 class="box-title pop">Hypertension (BP) Health Check - I</h3>
                    <div class="package-content">
                        <p class="text-dark">CBC - (Complete Blood Count), Glucose – Fasting, Glucose – PP, UREA, Creatinine, Cholesterol, Urine Analysis, Computerized ECG, Echo Cardiography / Computerized Treadmill, Complimentary Breakfast, Physician Consultation.</p>
                    </div>
                    <div class="price-btn">
                        <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Hypertension (BP) Health Check - I">Book Now</a>
                        <span class="h6 box-subtitle">₹ 3000</span>
                    </div>
                </div>
            </div>

            <!-- Package 8 -->
            <div class="col-xl-4 col-md-6">
                <div class="offer-card mega-hover">
                    <h3 class="box-title pop">Hypertension (BP) Health Check - II</h3>
                    <div class="package-content">
                        <p class="text-dark">CBC, FBS, PPBS, HbA1c, Lipid Profile, LFT, UREA, Creatinine, Uric Acid, Electrolytes, Micro-Albumin Spot, Computerized-ECG, Echo Cardiography, Computerized Treadmill, Complimentary Breakfast, Physician Consultation.</p>
                    </div>
                    <div class="price-btn">
                        <a href="#QuickView" class="th-btn btn-sm style4 popup-content book-now" data-package="Hypertension (BP) Health Check - II">Book Now</a>
                        <span class="h6 box-subtitle">₹ 4800</span>
                    </div>
                </div>
            </div>

      </div>
    </div>
  </section>



  <div id="QuickView" class="white-popup mfp-hide">
        <div class="container bg-white rounded-10">
            <div class="row gx-60">
                <div class="col-lg-6">
                    <div class="product-big-img">
                        <div class="img"><img src="assets/scan-world/package.png" alt="Product Image"></div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ps-xxl-5">
                        <form method="post" onsubmit="return validateForm();" class="faq-form2">
                            <h4 class="box-title text-center">Book Your Package</h4>
                            <div class="row">
                                <div class="form-group col-12">
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Your Name">
                                    <i class="fal fa-user"></i>
                                </div>
                                <div class="form-group col-12">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Email Address">
                                    <i class="fal fa-envelope"></i>
                                </div>
                                <div class="form-group col-12">
                                    <input type="tel" class="form-control" name="phone" id="number" placeholder="Phone Number">
                                    <i class="fal fa-phone"></i>
                                </div>
                                <div class="form-group col-12">
                                    <select name="package" id="subject" class="form-select">
                                        <option value="" disabled selected hidden>Select Package</option>
                                        
                                    </select>
                                    <i class="fal fa-chevron-down"></i>
                                </div>
                             
                                <div class="form-btn col-12">
                                    <button class="th-btn btn-fw" type="submit" id="submit_btn" value="Submit" name="submit_flag">BOOK NOW</button>
                                </div>
                            </div>
                            <p class="form-messages mb-0 mt-3"></p>
                        </form>
                    </div>
                </div>
            </div>
            <button title="Close (Esc)" type="button" class="mfp-close">×</button>
        </div>
    </div>

     <div id="loading-overlay" class="loading-overlay">
         <div class="spinner"></div>
     </div>

<script>document.querySelector(".faq-form2").addEventListener("submit", function() {
    document.getElementById("loading-overlay").style.display = "flex";
});
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
      // Get all "Book Now" buttons
      let bookButtons = document.querySelectorAll(".book-now");
      
      bookButtons.forEach(button => {
          button.addEventListener("click", function () {
              let packageName = this.getAttribute("data-package"); // Get package name from data attribute
              let packageSelect = document.getElementById("subject");

              // Clear existing options
              packageSelect.innerHTML = "";

              // Add selected package as an option and select it
              let option = document.createElement("option");
              option.value = packageName;
              option.textContent = packageName;
              option.selected = true;

              packageSelect.appendChild(option);
          });
      });
  });
</script>

  <?php include("footer.php") ?>
  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
    </svg>
  </div>

  <script src="assets/js/vendor/jquery-3.7.1.min.js"></script>
  <script src="assets/js/swiper-bundle.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.magnific-popup.min.js"></script>
  <script src="assets/js/jquery.counterup.min.js"></script>
  <script src="assets/js/jquery.datetimepicker.min.js"></script>
  <script src="assets/js/jquery-ui.min.js"></script>
  <script src="assets/js/imagesloaded.pkgd.min.js"></script>
  <script src="assets/js/isotope.pkgd.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>