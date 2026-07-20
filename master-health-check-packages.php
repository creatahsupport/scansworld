<?php include("includes/config.php"); ?>

<?php

require_once("mail/mail.php");

if (isset($_POST['submit_flag'])) {
  // Verify Cloudflare Turnstile
  $cf_turnstile_response = $_POST['cf-turnstile-response'] ?? '';
  global $cloudflare_secret_key;
  if (!verifyCloudflareTurnstile($cf_turnstile_response, $cloudflare_secret_key)) {
    http_response_code(403);
    echo "<script>alert('Captcha verification failed. Please try again.'); window.history.back();</script>";
    exit;
  }

  // Check for blacklisted words
  global $blacklist_words;
  $all_inputs = implode(" ", $_POST);
  if (containsBlacklistedWords($all_inputs, $blacklist_words)) {
    http_response_code(403);
    echo "<script>alert('Invalid input detected. Please remove restricted words.'); window.history.back();</script>";
    exit;
  }

  // Backend validation matching frontend
  $b_name = trim($_POST['name'] ?? '');
  $b_mail = trim($_POST["email"] ?? '');
  $b_phone = trim($_POST["phone"] ?? '');
  $be_package = trim($_POST['package'] ?? '');

  if (!preg_match('/^[a-zA-Z ]{3,50}$/', $b_name)) {
    http_response_code(400);
    echo "<script>alert('Invalid name. Only letters and spaces are allowed.'); window.history.back();</script>";
    exit;
  }

  if (!preg_match('/^[1-9][0-9]{9}$/', $b_phone)) {
    http_response_code(400);
    echo "<script>alert('Invalid phone number. Must be exactly 10 digits.'); window.history.back();</script>";
    exit;
  }

  // Validate Email
  if (!filter_var($b_mail, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "<script>alert('Invalid email format.'); window.history.back();</script>";
    exit;
  }

  // Validate Package
  $valid_packages = ["Basic Health Package", "Advanced Health Checkup", "Premium Health Checkup", "Basic Master Health Check", "Vital Master Health Check", "Executive Master Health Check", "Basic Well Women Health Check", "Comprehensive Well Women Health Check", "Executive Well Women Health Check", "Diabetic Profile I", "Diabetic Profile II", "Hypertension (BP) Health Check I", "Hypertension (BP) Health Check II", "Vital Heart Check", "Executive Heart Check", "Vital Senior Citizen Health Check", "Advanced Senior Citizen Health Check", "Vital School Health Check", "Pre Employment Health Check", "Pre Marital Check Up", "Whole Body Cancer Check Up", "Whole Body Health Check For Men", "Whole Body Health Check For Women"];
  if (!in_array($be_package, $valid_packages)) {
    http_response_code(400);
    echo "<script>alert('Invalid package selected.'); window.history.back();</script>";
    exit;
  }


  $ip_address = getUserIP();

  $subject = "New Enquiry - Request Callback";
  $admin_msg = "<p>Dear Admin,</p>
    <p>You have received a request callback enquiry. Please check the details below:</p>
    <p>Name: " . $b_name . "</p>
    <p>Email: " . $b_mail . "</p>
    <p>Phone: " . $b_phone . "</p>
    <p>Package: " . $be_package . "</p>
    <p>IP Address: " . $ip_address . "</p>";

  // Send email
  mailer($subject, $admin_msg, $To_email);

  http_response_code(200);
  echo "<script>
    setTimeout(function() {
        window.location.href = 'packages-thankyou';
    }, 2000);
</script>";
  exit();

}
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
  <link rel="preload" as="style"
    href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
    onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap"></noscript>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/fontawesome.min.css">
  <link rel="preload" as="style" href="assets/css/magnific-popup.min.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="assets/css/magnific-popup.min.css"></noscript>
  <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
  <link rel="preload" as="style" href="assets/css/jquery.datetimepicker.min.css" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css"></noscript>
  <link rel="stylesheet" href="assets/css/style.css">
  <!-- Cloudflare Turnstile -->
  <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<style>
/* ======================================================
   FIXED HEIGHT CARDS WITH SCROLLABLE CONTENT
   NO HTML CHANGES NEEDED - WORKS WITH YOUR EXISTING CODE
   ====================================================== */

/* Make all cards equal height */
.fixed-height-card {
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* Card body as flex column */
.fixed-height-card .card-body {
    display: flex;
    flex-direction: column;
    flex: 1;
    overflow: hidden;
}

/* Make the entire row content scrollable - wraps both tests and complimentary */
.fixed-height-card .card-body .row:first-of-type,
.fixed-height-card .card-body .row.mt-1 {
    max-height: 180px;
    overflow-y: auto;
    padding-right: 4px;
    margin-bottom: 4px;
}

/* Also handle when there's no mt-1 row (single row) */
.fixed-height-card .card-body .row:only-of-type {
    max-height: 180px;
    overflow-y: auto;
    padding-right: 4px;
}

/* Custom scrollbar - subtle */
.fixed-height-card .card-body .row:first-of-type::-webkit-scrollbar,
.fixed-height-card .card-body .row.mt-1::-webkit-scrollbar {
    width: 3px;
}

.fixed-height-card .card-body .row:first-of-type::-webkit-scrollbar-track,
.fixed-height-card .card-body .row.mt-1::-webkit-scrollbar-track {
    background: transparent;
}

.fixed-height-card .card-body .row:first-of-type::-webkit-scrollbar-thumb,
.fixed-height-card .card-body .row.mt-1::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
}

/* For Firefox */
.fixed-height-card .card-body .row:first-of-type,
.fixed-height-card .card-body .row.mt-1 {
    scrollbar-width: thin;
    scrollbar-color: #ccc transparent;
}

/* Push price box to bottom */
.fixed-height-card .price-box {
    margin-top: auto;
    flex-shrink: 0;
}

/* Ensure button stays at bottom */
.fixed-height-card .text-center.mt-3 {
    flex-shrink: 0;
    margin-top: auto !important;
    padding-top: 8px;
}

/* Keep single column - no grid */
.checklist ul {
    padding-left: 0;
    list-style: none;
    margin-bottom: 4px;
}

.checklist ul li {
    font-size: 14px;
    padding: 2px 0;
    display: flex;
    align-items: flex-start;
}

.checklist ul li i {
    margin-right: 6px;
    margin-top: 2px;
    flex-shrink: 0;
}
/* Responsive */
@media (max-width: 768px) {
    .fixed-height-card .card-body .row:first-of-type,
    .fixed-height-card .card-body .row.mt-1 {
        max-height: 150px;
    }
}

@media (max-width: 576px) {
    .fixed-height-card .card-body .row:first-of-type,
    .fixed-height-card .card-body .row.mt-1 {
        max-height: 130px;
    }
}
.guidelines-section {
    background: #f5f7fa;
    padding: 50px 0;
}

.guidelines-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

/* Section Header */
.guidelines-header {
    text-align: center;
    margin-bottom: 40px;
}

.guidelines-header .sub-title {
    display: inline-block;
    background: linear-gradient(135deg, #1a237e, #0d1445);
    color: #fff;
    padding: 4px 20px;
    border-radius: 30px;
    font-size: 14.5px;
    font-weight: 600;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 10px;
}

.guidelines-header .section-title {
    font-size: 32px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.guidelines-header .section-title span {
    color: #FF6B00;
}

.guidelines-header .section-desc {
    color: #666;
    font-size: 16px;
    max-width: 600px;
    margin: 0 auto;
}

/* Guidelines Grid - 4 columns */
.guidelines-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

/* Guideline Card */
.guideline-card {
    background: #ffffff;
    border-radius: 12px;
    padding: 20px 18px;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    border-left: 4px solid #1a237e;
}

.guideline-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.guideline-card .guideline-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #1a237e, #0d1445);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 10px;
}

.guideline-card .guideline-icon i {
    color: #fff;
    font-size: 18px;
}

.guideline-card h4 {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
    margin-bottom: 8px;
}

.guideline-card ul {
    padding-left: 0;
    list-style: none;
    margin-bottom: 0;
}

.guideline-card ul li {
    font-size: 14px;
    color: #555;
    padding: 3px 0;
    display: flex;
    align-items: flex-start;
    line-height: 1.4;
}

.guideline-card ul li i {
    margin-right: 8px;
    margin-top: 3px;
    flex-shrink: 0;
}

.guideline-card ul li .fa-check-circle {
    color: #28a745;
    font-size: 13px;
}

.guideline-card ul li .fa-phone,
.guideline-card ul li .fa-mobile-alt,
.guideline-card ul li .fa-envelope {
    color: #FF6B00;
    font-size: 13px;
}

/* Highlight Card - for contact */
.guideline-card.highlight-card {
    background: linear-gradient(135deg, #1a237e, #0d1445);
    border-left-color: #FF6B00;
}

.guideline-card.highlight-card .guideline-icon {
    background: #FF6B00;
}

.guideline-card.highlight-card h4 {
    color: #fff;
}

.guideline-card.highlight-card ul li {
    color: #e0e0e0;
}

.guideline-card.highlight-card ul li i {
    color: #FF6B00;
}

.guideline-card.highlight-card ul li strong {
    color: #fff;
}

/* Responsive */
@media (max-width: 1024px) {
    .guidelines-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .guidelines-header .section-title {
        font-size: 24px;
    }
    
    .guidelines-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .guideline-card {
        padding: 16px;
    }
}

@media (max-width: 576px) {
    .guidelines-section {
        padding: 30px 0;
    }
    
    .guidelines-header .section-title {
        font-size: 20px;
    }
    
    .guideline-card ul li {
        font-size: 12px;
    }
}
/* Space between package cards on mobile */
@media (max-width: 768px) {
    .space .container .row .col-md-4 {
        margin-bottom: 25px;
    }
    
    .space .container .row .col-md-4:last-child {
        margin-bottom: 0;
    }
}

@media (max-width: 576px) {
    .space .container .row .col-md-4 {
        margin-bottom: 20px;
    }
    
    .space .container .row .col-md-4:last-child {
        margin-bottom: 0;
    }
}
</style>
</head>

<body>
  <?php include 'header.php'; ?>

  <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/packages-breadcrumb.png">
    <div class="container">
      <div class="breadcumb-content">
        <h3 class="breadcumb-title text-white">Master Health Checkup Packages</h3>
        <ul class="breadcumb-menu">
          <li><a href="./" class="text-white">Home</a></li>
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
    <div class="container mt-4">
        <div class="row">

            <!-- 1. BASIC MASTER HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Basic Master Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – PP</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine & Cholesterol</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Whole Abdomen (Screening)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>9</div>
                            <div>Package Price <br>₹1,750</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. VITAL MASTER HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Vital Master Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – PP</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Whole Abdomen</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>11</div>
                            <div>Package Price <br>₹5,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. EXECUTIVE MASTER HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Executive Master Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Whole Abdomen (Screening)</li>
                                        <li><i class="fas fa-check-circle"></i> Pulmonary Function Test</li>
                                        <li><i class="fas fa-check-circle"></i> Echo Cardiography</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized Treadmill</li>
                                        <li><i class="fas fa-check-circle"></i> PAP Smear</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Elastogram (Fibroscan)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation & Physical Examination</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>16</div>
                            <div>Package Price <br>₹7,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- 4. BASIC WELL WOMEN HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Basic Well Women Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                              
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> TSH</li>
                                        <li><i class="fas fa-check-circle"></i> PAP Smear</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Whole Abdomen (Screening)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation & Physical Examination</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>10</div>
                            <div>Package Price <br>₹4,800</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. COMPREHENSIVE WELL WOMEN HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Comprehensive Well Women Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Thyroid Function Test (T3, T4, TSH)</li>
                                        <li><i class="fas fa-check-circle"></i> PAP Smear</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Whole Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Sono Mammography</li>
                                        <li><i class="fas fa-check-circle"></i> Digital Mammography</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Elastogram (Fibroscan)</li>
                                        <li><i class="fas fa-check-circle"></i> Pulmonary Function Test</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation & Physical Examination</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>17</div>
                            <div>Package Price <br>₹6,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. EXECUTIVE WELL WOMEN HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Executive Well Women Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Thyroid Function Test (T3, T4, TSH)</li>
                                        <li><i class="fas fa-check-circle"></i> PAP Smear</li>
                                        <li><i class="fas fa-check-circle"></i> CA-125, CEA</li>
                                        <li><i class="fas fa-check-circle"></i> Vit B12, Vit D3</li>
                                        <li><i class="fas fa-check-circle"></i> Prolactin, Estrogen, Progesterone</li>
                                        <li><i class="fas fa-check-circle"></i> Calcium, Phosphorus, Iron</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Whole Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Sono Mammography</li>
                                        <li><i class="fas fa-check-circle"></i> Digital Mammography</li>
                                        <li><i class="fas fa-check-circle"></i> Echo Cardiography</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized Treadmill</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Elastogram (Fibroscan)</li>
                                        <li><i class="fas fa-check-circle"></i> Whole Body Bone Density (DEXA)</li>
                                        <li><i class="fas fa-check-circle"></i> Whole Body Fat Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Pulmonary Function Test</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>25</div>
                            <div>Package Price <br>₹12,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- 7. DIABETIC PROFILE I -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Diabetic Profile I
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Cholesterol</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis (Routine)</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> -</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>6</div>
                            <div>Package Price <br>₹1,200</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 8. DIABETIC PROFILE II -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Diabetic Profile II
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                             
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Cholesterol</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis (Routine)</li>
                                        <li><i class="fas fa-check-circle"></i> Thyroid Function Test (T3, T4, TSH)</li>
                                        <li><i class="fas fa-check-circle"></i> Micro Albumin Spot</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> Ophthal Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>8</div>
                            <div>Package Price <br>₹2,500</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 9. HYPERTENSION (BP) HEALTH CHECK – I -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Hypertension (BP) Health Check I
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Cholesterol</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> Echo Cardiography / Computerized Treadmill</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>6</div>
                            <div>Package Price <br>₹3,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- 10. HYPERTENSION (BP) HEALTH CHECK – II -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Hypertension (BP) Health Check II
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Electrolytes</li>
                                        <li><i class="fas fa-check-circle"></i> Micro Albumin Spot</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> Echo Cardiography / Computerized Treadmill</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>10</div>
                            <div>Package Price <br>₹4,800</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 11. VITAL HEART CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Vital Heart Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> HsCRP</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Echocardiography</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized Treadmill</li>
                                        <li><i class="fas fa-check-circle"></i> Carotid Intimal Thickness</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>15</div>
                            <div>Package Price <br>₹8,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 12. EXECUTIVE HEART CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Executive Heart Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Hs-CRP</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Complete Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Echocardiography</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized Treadmill</li>
                                        <li><i class="fas fa-check-circle"></i> Pulmonary Function Test</li>
                                        <li><i class="fas fa-check-circle"></i> Carotid Intimal Thickness</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician/Cardiologist Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>16</div>
                            <div>Package Price <br>₹11,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- 13. VITAL SENIOR CITIZEN HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Vital Senior Citizen Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                              
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Complete Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Pulmonary Function Test</li>
                                        <li><i class="fas fa-check-circle"></i> PSA Total (Male)</li>
                                        <li><i class="fas fa-check-circle"></i> CA-125 (Female)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>14</div>
                            <div>Package Price <br>₹3,600</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 14. ADVANCED SENIOR CITIZEN HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Advanced Senior Citizen Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Calcium, Electrolytes</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Complete Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Echocardiography</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized Treadmill</li>
                                        <li><i class="fas fa-check-circle"></i> Pulmonary Function Test</li>
                                        <li><i class="fas fa-check-circle"></i> PSA Total (Male)</li>
                                        <li><i class="fas fa-check-circle"></i> CA 125 (Female)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>16</div>
                            <div>Package Price <br>₹6,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 15. VITAL SCHOOL HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Vital School Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Blood Group & Rh Type</li>
                                        <li><i class="fas fa-check-circle"></i> Calcium, Phosphorous, Vitamin-D</li>
                                        <li><i class="fas fa-check-circle"></i> ESR</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> USG Abdomen</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>8</div>
                            <div>Package Price <br>₹2,900</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- 16. PRE EMPLOYMENT HEALTH CHECK -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Pre Employment Health Check
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Cholesterol</li>
                                        <li><i class="fas fa-check-circle"></i> Blood Group & Rh Type</li>
                                        <li><i class="fas fa-check-circle"></i> HIV, HBsAg, VDRL</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Eye Examination</li>
                                        <li><i class="fas fa-check-circle"></i> Puretone Audiometry</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>12</div>
                            <div>Package Price <br>₹3,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 17. PRE MARITAL CHECK UP -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Pre Marital Check Up
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                          
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Cholesterol</li>
                                        <li><i class="fas fa-check-circle"></i> Blood Group & Rh Type</li>
                                        <li><i class="fas fa-check-circle"></i> Semen Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Scrotal Doppler</li>
                                        <li><i class="fas fa-check-circle"></i> HIV, HBsAg, HCV, VDRL</li>
                                        <li><i class="fas fa-check-circle"></i> Hormone Profile (F) - Estrogen, FSH, LH, Progesterone, Prolactin, CA-125</li>
                                        <li><i class="fas fa-check-circle"></i> Hormone Profile (M) – PSA, Testosterone</li>
                                        <li><i class="fas fa-check-circle"></i> Thyroid Function Test</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>11</div>
                            <div>Package Price <br>₹6,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 18. WHOLE BODY CANCER CHECK UP -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Whole Body Cancer Check Up
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> Whole Body MRI</li>
                                        <li><i class="fas fa-check-circle"></i> AFP, CA19.9, CEA</li>
                                        <li><i class="fas fa-check-circle"></i> Bence Jones Proteins</li>
                                        <li><i class="fas fa-check-circle"></i> Stool for Occult Blood</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> USG Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Male: PSA (Free & Total)</li>
                                        <li><i class="fas fa-check-circle"></i> Female: USG Sono Mammography, Digital X-Ray Mammography, PAP Smear, CA15.3, CA-125, Beta HCG, Thyroglobulin</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>8</div>
                            <div>Package Price <br>₹15,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- 19. WHOLE BODY HEALTH CHECK FOR MEN -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Whole Body Health Check For Men
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> HIV, HBsAg</li>
                                        <li><i class="fas fa-check-circle"></i> Vitamin-D</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Electrolytes</li>
                                        <li><i class="fas fa-check-circle"></i> Thyroid Function Test (T3, T4, TSH)</li>
                                        <li><i class="fas fa-check-circle"></i> Cardiac Profile (CPK Total, hsCRP)</li>
                                        <li><i class="fas fa-check-circle"></i> Coronary Risk Markers (Apo Lipoprotein A1 & B)</li>
                                        <li><i class="fas fa-check-circle"></i> Cancer Marker - PSA Total</li>
                                        <li><i class="fas fa-check-circle"></i> AFP, CA19.9, CEA</li>
                                        <li><i class="fas fa-check-circle"></i> Bence Jones Proteins</li>
                                        <li><i class="fas fa-check-circle"></i> Stool for Occult Blood</li>
                                        <li><i class="fas fa-check-circle"></i> Calcium, Phosphorus, Iron</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Echo Cardiography</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized Treadmill</li>
                                        <li><i class="fas fa-check-circle"></i> Pulmonary Function Test</li>
                                        <li><i class="fas fa-check-circle"></i> USG Carotid Doppler</li>
                                        <li><i class="fas fa-check-circle"></i> CT Scan Brain & PNS</li>
                                        <li><i class="fas fa-check-circle"></i> MRI Whole Spine Survey</li>
                                        <li><i class="fas fa-check-circle"></i> Whole Body Bone Density (DEXA)</li>
                                        <li><i class="fas fa-check-circle"></i> Whole Body Fat Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Male: PSA (Free & Total)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>31</div>
                            <div>Package Price <br>₹20,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 20. WHOLE BODY HEALTH CHECK FOR WOMEN -->
            <div class="col-md-4">
                <div class="card card-custom fixed-height-card">
                    <div class="card-header-custom text-white">
                        Whole Body Health Check For Women
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               
                                <div class="checklist mb-25 two-col-list">
                                    <ul>
                                        <li><i class="fas fa-check-circle"></i> CBC (Complete Blood Count)</li>
                                        <li><i class="fas fa-check-circle"></i> Glucose – Fasting & PP</li>
                                        <li><i class="fas fa-check-circle"></i> HbA1c</li>
                                        <li><i class="fas fa-check-circle"></i> Lipid Profile (Total Cholesterol, Triglycerides, HDL, LDL, VLDL, Cholesterol/HDL Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Liver Function Test (Bilirubin - Total/Direct/Indirect, SGOT, SGPT, Alkaline Phosphatase, GGT, Total Protein, Albumin, Globulin, A/G Ratio)</li>
                                        <li><i class="fas fa-check-circle"></i> Urea, Creatinine, Uric Acid</li>
                                        <li><i class="fas fa-check-circle"></i> Electrolytes</li>
                                        <li><i class="fas fa-check-circle"></i> Thyroid Function Test (T3, T4, TSH)</li>
                                        <li><i class="fas fa-check-circle"></i> Cardiac Profile (CPK Total, hsCRP)</li>
                                        <li><i class="fas fa-check-circle"></i> Coronary Risk Markers (Apo Lipoprotein A1 & B)</li>
                                        <li><i class="fas fa-check-circle"></i> Cancer Marker - CA 125 Total</li>
                                        <li><i class="fas fa-check-circle"></i> Female: PAP Smear, CA15.3, CA 125, Beta HCG, Thyroglobulin</li>
                                        <li><i class="fas fa-check-circle"></i> Urine Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Stool Analysis</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Chest</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized ECG</li>
                                        <li><i class="fas fa-check-circle"></i> USG Abdomen</li>
                                        <li><i class="fas fa-check-circle"></i> Echo Cardiography</li>
                                        <li><i class="fas fa-check-circle"></i> Computerized Treadmill</li>
                                        <li><i class="fas fa-check-circle"></i> Pulmonary Function Test</li>
                                        <li><i class="fas fa-check-circle"></i> USG Sono Mammography</li>
                                        <li><i class="fas fa-check-circle"></i> Digital X-Ray Mammography</li>
                                        <li><i class="fas fa-check-circle"></i> USG Thyroid Scan</li>
                                        <li><i class="fas fa-check-circle"></i> CT Scan Brain & PNS</li>
                                        <li><i class="fas fa-check-circle"></i> MRI Whole Spine Survey</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-12">
                                <b>Complimentary</b>
                                <div class="checklist mb-25">
                                    <ul>
                                        <li><i class="fas fa-gift"></i> Breakfast</li>
                                        <li><i class="fas fa-gift"></i> Physician Consultation</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="price-box">
                            <div>Tests Included <br>25</div>
                            <div>Package Price <br>₹25,000</div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="#QuickView" class="btn btn-custom">Book Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="guidelines-section space">
    <div class="container">
        <div class="guidelines-wrapper">
            <!-- Section Header -->
            <div class="guidelines-header">
                <span class="sub-title">Health Check Preparation</span>
                <h2 class="section-title">Preparation Guidelines for <span>Master Health Check</span></h2>
                <p class="section-desc">Follow these guidelines to ensure accurate test results and a smooth health check experience.</p>
            </div>

            <!-- Guidelines Grid -->
            <div class="guidelines-grid">
                <!-- Fasting Guidelines -->
                <div class="guideline-card">
                    <div class="guideline-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="guideline-content">
                        <h4>Fasting Requirements</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> 8 – 10 hours fasting for blood samples</li>
                            <li><i class="fas fa-check-circle"></i> No milk / tea / coffee in the morning before tests</li>
                            <li><i class="fas fa-check-circle"></i> You may drink water</li>
                            <li><i class="fas fa-check-circle"></i> Drink 1 litre of water while starting from home</li>
                        </ul>
                    </div>
                </div>

                <!-- Ultrasound Guidelines -->
                <div class="guideline-card">
                    <div class="guideline-icon">
                        <i class="fas fa-x-ray"></i>
                    </div>
                    <div class="guideline-content">
                        <h4>Ultrasound Abdomen</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> After adequate fasting to see the gall bladder</li>
                            <li><i class="fas fa-check-circle"></i> Adequate water intake to see pelvic organs</li>
                        </ul>
                    </div>
                </div>

                <!-- TMT / ECG Guidelines -->
                <div class="guideline-card">
                    <div class="guideline-icon">
                        <i class="fas fa-heartbeat"></i>
                    </div>
                    <div class="guideline-content">
                        <h4>TMT / ECG Preparation</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Sports shoes and tracks are preferred for TMT</li>
                            <li><i class="fas fa-check-circle"></i> Men should shave their chest for TMT / ECG</li>
                        </ul>
                    </div>
                </div>

                <!-- Important Notes -->
                <div class="guideline-card">
                    <div class="guideline-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="guideline-content">
                        <h4>Important Notes</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Pregnant women should not undergo chest X-ray</li>
                            <li><i class="fas fa-check-circle"></i> Spend 4 – 6 hours in the scan centre for your health check, once in a year.</li>
                            <li><i class="fas fa-check-circle"></i> Diabetic drug to be taken as usual</li>
                            <li><i class="fas fa-check-circle"></i> Bring old reports if diabetic or cardiac patient</li>
                        </ul>
                    </div>
                </div>

                <!-- Clothing & Belongings -->
                <div class="guideline-card">
                    <div class="guideline-icon">
                        <i class="fas fa-tshirt"></i>
                    </div>
                    <div class="guideline-content">
                        <h4>Clothing & Belongings</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Wear comfortable clothing (loose cotton clothes)</li>
                            <li><i class="fas fa-check-circle"></i> Comfortable footwear</li>
                            <li><i class="fas fa-check-circle"></i> Minimum or no accessories</li>
                            <li><i class="fas fa-check-circle"></i> Leave valuable items at home</li>
                        </ul>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="guideline-card">
                    <div class="guideline-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="guideline-content">
                        <h4>Additional Information</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Breakfast is complimentary (except Pre-Employment)</li>
                            <li><i class="fas fa-check-circle"></i> Complete physical examination in few packages</li>
                            <li><i class="fas fa-check-circle"></i> Make sure you are accompanied by a person</li>
                        </ul>
                    </div>
                </div>

                <!-- Check-in Details -->
                <div class="guideline-card">
                    <div class="guideline-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="guideline-content">
                        <h4>Check-in Details</h4>
                        <ul>
                            <li><i class="fas fa-check-circle"></i> Report at front desk at 07:30 AM</li>
                            <li><i class="fas fa-check-circle"></i> Bring your medical records, if any</li>
                            <li><i class="fas fa-check-circle"></i> Prior appointment is a must for all health checkup programmes.</li>
                        </ul>
                    </div>
                </div>

                <!-- Contact -->
                <div class="guideline-card highlight-card">
                    <div class="guideline-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="guideline-content">
                        <h4>Book Your Appointment</h4>
                        <ul>
                            <li><i class="fas fa-phone"></i> Call us at <strong>044-40699999</strong></li>
                            <li><i class="fas fa-mobile-alt"></i> Mobile: <strong>9626959999</strong></li>
                            <li><i class="fas fa-envelope"></i> Email: <strong>scansworld.chamiers@gmail.com</strong></li>
                        </ul>
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
            <div class="img"><img src="assets/scan-world/package.png" loading="lazy" decoding="async" alt="Product Image"></div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="ps-xxl-5">
            <form method="post" onsubmit="return validateForm();" class="faq-form2">
              <h4 class="box-title text-center">Book Your Package</h4>
              <div class="row">
                <div class="form-group col-12">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Your Name" minlength="3"
                    maxlength="50" required oninput="this.value = this.value.replace(/[^a-zA-Z ]/g, '');"
                    title="Name must be 3–50 characters. Letters and spaces only.">
                  <i class="fal fa-user"></i>
                </div>
                <div class="form-group col-12">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                  <i class="fal fa-envelope"></i>
                </div>
                <div class="form-group col-12">
                  <input type="tel" class="form-control" name="phone" id="number" placeholder="Phone Number" required
                    inputmode="numeric" pattern="[1-9][0-9]{9}" maxlength="10" title="Enter exactly 10 digits."
                    onkeydown="if(event.key.length===1 && !/[0-9]/.test(event.key)) event.preventDefault();"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                  <i class="fal fa-phone"></i>
                </div>
                <div class="form-group col-12">
                  <select name="package" id="packageSelect" class="form-select" required>
                    <option value="" disabled selected hidden>Select Package</option>
                    <option value="Basic Health Package">Basic Health Package</option>
                    <option value="Advanced Health Checkup">Advanced Health Checkup</option>
                    <option value="Premium Health Checkup">Premium Health Checkup</option>
                    <option value="Basic Master Health Check">Basic Master Health Check</option>
                    <option value="Vital Master Health Check">Vital Master Health Check</option>
                    <option value="Executive Master Health Check">Executive Master Health Check</option>
                    <option value="Basic Well Women Health Check">Basic Well Women Health Check</option>
                    <option value="Comprehensive Well Women Health Check">Comprehensive Well Women Health Check</option>
                    <option value="Executive Well Women Health Check">Executive Well Women Health Check</option>
                    <option value="Diabetic Profile I">Diabetic Profile I</option>
                    <option value="Diabetic Profile II">Diabetic Profile II</option>
                    <option value="Hypertension (BP) Health Check I">Hypertension (BP) Health Check I</option>
                    <option value="Hypertension (BP) Health Check II">Hypertension (BP) Health Check II</option>
                    <option value="Vital Heart Check">Vital Heart Check</option>
                    <option value="Executive Heart Check">Executive Heart Check</option>
                    <option value="Vital Senior Citizen Health Check">Vital Senior Citizen Health Check</option>
                    <option value="Advanced Senior Citizen Health Check">Advanced Senior Citizen Health Check</option>
                    <option value="Vital School Health Check">Vital School Health Check</option>
                    <option value="Pre Employment Health Check">Pre Employment Health Check</option>
                    <option value="Pre Marital Check Up">Pre Marital Check Up</option>
                    <option value="Whole Body Cancer Check Up">Whole Body Cancer Check Up</option>
                    <option value="Whole Body Health Check For Men">Whole Body Health Check For Men</option>
                    <option value="Whole Body Health Check For Women">Whole Body Health Check For Women</option>
                  </select>
                  <i class="fal fa-chevron-down"></i>
                </div>

                <div class="form-btn col-12 text-center">
                  <div class="cf-turnstile d-inline-block" data-sitekey="<?php echo $cloudflare_site_key; ?>"
                    style="margin-top: 15px; margin-bottom: 15px;"></div>
                  <button class="th-btn btn-fw mt-3" type="submit" id="submit_btn" value="Submit" name="submit_flag">
                    BOOK NOW
                  </button>
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
  <!-- Include Magnific Popup CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

  <!-- Include Magnific Popup JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

  <script>
    $(document).ready(function () {
      // Initialize Magnific Popup
      $('.btn-custom, .know-more').magnificPopup({
        type: 'inline',
        midClick: true,
        removalDelay: 300,
        mainClass: 'mfp-fade',
        callbacks: {
          open: function () {
            // Get package name from clicked button
            var packageName = $.magnificPopup.instance.st.el.data('package');
            if (packageName) {
              $('#packageSelect').val(packageName);
            } else {
              $('#packageSelect').val('');
            }
          }
        }
      });

      // Attach package name to each button
      $('.btn-custom').each(function () {
        var pkg = $(this).closest('.card').find('.card-header-custom').text().trim();
        $(this).attr('data-package', pkg);
      });
    });
    function validateForm() {
      let name = $('#name').val().trim();
      let email = $('#email').val().trim();
      let phone = $('#number').val().trim();
      let pkg = $('#packageSelect').val();

      if (!name || !email || !phone || !pkg) {
        alert('Please fill all fields.');
        return false;
      }
      return true;
    }

  </script>



  <?php include("footer.php") ?>
  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
        style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
      </path>
    </svg>
  </div>

  <script src="assets/js/vendor/jquery-3.7.1.min.js" defer></script>
  <script src="assets/js/swiper-bundle.min.js" defer></script>
  <script src="assets/js/bootstrap.min.js" defer></script>
  <script src="assets/js/jquery.magnific-popup.min.js" defer></script>
  <script src="assets/js/jquery.counterup.min.js" defer></script>
  <script src="assets/js/jquery.datetimepicker.min.js" defer></script>
  <script src="assets/js/jquery-ui.min.js" defer></script>
  <script src="assets/js/imagesloaded.pkgd.min.js" defer></script>
  <script src="assets/js/isotope.pkgd.min.js" defer></script>
  <script src="assets/js/main.js" defer></script>
</body>

</html>
