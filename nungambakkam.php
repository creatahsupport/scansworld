<?php
include("includes/config.php");

// Fetch latest 20 doctors
$doctor_image_path = "uploads/doctor_images/";
$doctors_query = "SELECT * FROM doctors WHERE del_i = 0 ORDER BY id ASC LIMIT 20";
$latest_doctors = mysqli_query($con, $doctors_query);
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
<?php include("doctor-details.php") ?>
    <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/breadcrumb.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title text-white"> Scans World On Chamiers Road</h1>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Nandanam</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row flex-row-reverse">
           
                <div class="col-xl-6 text-center text-xl-start">
                    <div class="title-area mb-32">
                    <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">About our Center</span>
                        <h2 class="sec-title">The Best Diagnostic Centre in Chennai</h2>
                        <p class="sec-text">As the best diagnostic center in Chennai, we provide advanced imaging and diagnostic solutions, including PET-CT, MRI, ECG, and comprehensive health checkups. With cutting-edge technology and expert care, we ensure accurate and timely diagnoses for better health outcomes.</p>
                    </div>
                    <div class="mb-4 mt-n1">
                        <div class="checklist style2 list-two-column">
                            <ul>
                                <li><i class="fas fa-shield-check text-theme2"></i> Advanced Imaging</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Comprehensive Health Checkups</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> State-of-the-Art Technology</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Expert Medical Team</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Accurate & Timely Reports</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Patient-Centric Approach</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a href="book-appointment" class="th-btn">Online Appointment</a>
                    </div>
                </div>
                <div class="col-xl-6 mb-40 mb-xl-0">
                    <div class="img-box7" style="margin: 0px 50px 0px 0px;">
                        <div class="img1">
                            <img data-mask-src="assets/img/normal/about_4_mask.png" src="assets/scan-world/centers/nandanam.png" alt="About">
                        </div>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-smoke space" data-bg-src="assets/img/bg/why_bg_3.jpg">
        <div class="container">
            <div class="row align-items-center">
              
              
                <div class="col-xl-4 col-md-6">
                    <div class="location-card">
                        <h3 class="box-title">Nandanam Branch</h3>
                        <p class="footer-info">
                            <i class="far fa-location-dot"></i>
                            No. 127, Basement, Chamiers Road, Nandanam, Chennai – 600 035
                        </p>
                        <p class="footer-info">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:scansworldonchamiersroad@gmail.com" class="info-box_link">scansworldonchamiersroad@gmail.com</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-phone"></i>
                            <a href="tel:+04440699999" class="info-box_link"> 044 4069 9999</a>
                        </p>
                        <p class="footer-info">
                        <i class="fa fa-mobile"></i>
                            <a href="tel:+919626959999" class="info-box_link"> +91 96269 59999</a>
                        </p>
                    </div>
                    <div class="contact-feature">
                        <div class="box-icon">
                            <i class="far fa-clock"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">Working Hours</h3>
                            <p class="box-text">Mon to sat: 8:00am - 9:00pm</p>
                            <p class="box-schedule">Sunday - Closed</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3887.0961806121522!2d80.24033867489408!3d13.029546787291201!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5267bff3c22b3f%3A0xe1dfa4f6968d1dc1!2sScans%20World%20-%20Chamiers%20Road!5e0!3m2!1sen!2sin!4v1743082082300!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    <section class="overflow-hidden bg-smoke space" id="service-sec" data-bg-src="assets/scan-world/home/service_bg_1.webp">
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
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="service-card" data-bg-src="assets/scan-world/home/service-1.webp">
            <div class="box-shape">
              <img src="assets/img/bg/service_card_bg.png" alt="Service">
            </div>
            <div class="box-icon">
              <img src="assets/scan-world/service-icon/mri.png" alt="Icon">
            </div>
            <h3 class="box-title pb-3"><a href="mri-scan">MRI Scan</a></h3>

            <a href="mri-scan" class="th-btn btn-sm style2 theme-color">Read More</a>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="service-card" data-bg-src="assets/scan-world/home/service-2.webp">
            <div class="box-shape">
              <img src="assets/img/bg/service_card_bg.png" alt="Service">
            </div>
            <div class="box-icon">
              <img src="assets/scan-world/service-icon/ct-scan.png" alt="Icon">
            </div>
            <h3 class="box-title pb-3"><a href="ct-scan">CT Scan</a></h3>

            <a href="ct-scan" class="th-btn btn-sm style2 theme-color">Read More</a>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="service-card" data-bg-src="assets/scan-world/home/service-1.webp">
            <div class="box-shape">
              <img src="assets/img/bg/service_card_bg.png" alt="Service">
            </div>
            <div class="box-icon">
              <img src="assets/scan-world/service-icon/wine-barrel.png" alt="Icon">
            </div>
            <h3 class="box-title pb-3"><a href="ct-scan">PET CT Scan</a></h3>

            <a href="ct-scan" class="th-btn btn-sm style2 theme-color">Read More</a>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="service-card" data-bg-src="assets/scan-world/home/service-3.webp">
            <div class="box-shape">
              <img src="assets/img/bg/service_card_bg.png" alt="Service">
            </div>
            <div class="box-icon">
              <img src="assets/scan-world/service-icon/ultrasound.png" alt="Icon">
            </div>
            <h3 class="box-title pb-3"><a href="ct-scan">Ultrasound</a></h3>

            <a href="ct-scan" class="th-btn btn-sm style2 theme-color">Read More</a>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="service-card" data-bg-src="assets/scan-world/home/service-4.webp">
            <div class="box-shape">
              <img src="assets/img/bg/service_card_bg.png" alt="Service">
            </div>
            <div class="box-icon">
              <img src="assets/scan-world/service-icon/clinic.png" alt="Icon">
            </div>
            <h3 class="box-title pb-3"><a href="ct-scan">Digital X-Ray</a></h3>

            <a href="ct-scan" class="th-btn btn-sm style2 theme-color">Read More</a>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="service-card" data-bg-src="assets/scan-world/home/service-5.webp">
            <div class="box-shape">
              <img src="assets/img/bg/service_card_bg.png" alt="Service">
            </div>
            <div class="box-icon">
              <img src="assets/scan-world/service-icon/heart-rate-monitor.png" alt="Icon">
            </div>
            <h3 class="box-title pb-3"><a href="ct-scan">ECG & TMT</a></h3>

            <a href="ct-scan" class="th-btn btn-sm style2 theme-color">Read More</a>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="service-card" data-bg-src="assets/scan-world/home/service-6.webp">
            <div class="box-shape">
              <img src="assets/img/bg/service_card_bg.png" alt="Service">
            </div>
            <div class="box-icon">
              <img src="assets/scan-world/service-icon/blood-sample.png" alt="Icon">
            </div>
            <h3 class="box-title pb-3"><a href="ct-scan">Blood Tests & Pathology</a></h3>

            <a href="ct-scan" class="th-btn btn-sm style2 theme-color">Read More</a>
          </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-sm-6">
          <div class="service-card" data-bg-src="assets/scan-world/home/service-7.webp">
            <div class="box-shape">
              <img src="assets/img/bg/service_card_bg.png" alt="Service">
            </div>
            <div class="box-icon">
              <img src="assets/scan-world/service-icon/stethoscope.png" alt="Icon">
            </div>
            <h3 class="box-title pb-3"><a href="ct-scan">Master Health Checkups</a></h3>

            <a href="ct-scan" class="th-btn btn-sm style2 theme-color">Read More</a>
          </div>
        </div>
  
      </div>

    </div>
  </section>
    <section class="space">
        <div class="container">
            <div class="title-area text-center">
            <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Scans World</span>
                <h2 class="sec-title">Meet Our Experts</h2>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider has-shadow" id="teamSlider3" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        <!-- Single Item -->
                        <?php if ($latest_doctors->num_rows > 0) { ?>
                            <?php while ($row = $latest_doctors->fetch_assoc()) { ?>
                        <div class="swiper-slide">
                            <div class="th-team team-grid">
                                <div class="box-img">
                                <img src="<?php echo htmlspecialchars($url_config . '/' . $doctor_image_path . $row['doctor_image']); ?>" 
                         alt="<?= htmlspecialchars($row['image_alttag']); ?>" 
                         title="<?= htmlspecialchars($row['image_title']); ?>">
                            
                                </div>
                                <div class="box-content">
                                    <h3 class="box-title"><a href="#" 
                           class="doctor-detail" 
                           data-name="<?= htmlspecialchars($row['doctor_name']); ?>" 
                           data-studies="<?= htmlspecialchars($row['doctor_studies']); ?>" 
                           data-image="<?= htmlspecialchars($url_config . '/' . $doctor_image_path . $row['doctor_image']); ?>" 
                           data-content="<?= htmlspecialchars($row['doctor_content']); ?>" 
                           data-bs-toggle="modal" 
                           data-bs-target="#exampleModal">
                            <?= htmlspecialchars($row['doctor_name']); ?>
                        </a></h3>
                                    <p class="box-text"><?= htmlspecialchars($row['doctor_studies']); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
<?php } else { ?>
    <div class="col-12">
        <div class="text-center" role="alert">
            No Data Found.
        </div>
    </div>
<?php } ?>
                    </div>
                </div>
                <button data-slider-prev="#teamSlider3" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>
                <button data-slider-next="#teamSlider3" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>
            </div>
        </div>
    </section>
    <section class="why-sec3 space-top" id="why-sec" data-bg-src="assets/img/bg/why_bg_3.jpg">
        <div class="container pb-5 mb-2">
            <div class="row justify-content-center">
                <div class="col-lg-7 col-md-8">
                    <div class="title-area text-center">
                        <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Why Choose Us</span>
                        <h2 class="sec-title">We Have 25 Years Experience in Medical Health Services</h2>
                    </div>
                </div>
            </div>
            <div class="row gy-4">
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icon">
                            <img src="assets/scan-world/centers/team.png" alt="icon">
                        </div>
                        <h3 class="box-title">Experienced Team</h3>
                      
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icon">
                            <img src="assets/scan-world/centers/master.png" alt="icon">
                        </div>
                        <h3 class="box-title">Master Health Check-ups</h3>
                      
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icon">
                            <img src="assets/scan-world/centers/lap.png" alt="icon">
                        </div>
                        <h3 class="box-title">Advanced Lab Facilities
                        </h3>
                      
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icon">
                            <img src="assets/scan-world/centers/open-24-hours.png" alt="icon">
                        </div>
                        <h3 class="box-title">24/7 Service</h3>
                      
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icon">
                            <img src="assets/scan-world/centers/green-city.png" alt="icon">
                        </div>
                        <h3 class="box-title">Eco Friendly Environment</h3>
                      
                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icon">
                            <img src="assets/scan-world/centers/parking.png" alt="icon">
                        </div>
                        <h3 class="box-title">Ample car parking space </h3>
                      
                    </div>
                </div>
            </div>
        </div>
    </section>
  
    <section class="space">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="Icon">Work Process</span>
                <h2 class="sec-title">Seamless Scan Process for <br>Accurate Diagnosis</h2>
            </div>
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
    <section class="cta-sec7 space" data-bg-src="assets/scan-world/cta.png">
        <div class="container">
            <h2 class="sec-title mb-md-4 mb-2">Need a Scan for Diagnosis?</h2>
            <h4 class="text-theme fw-semibold mb-4 mb-md-5">Get Accurate Results with Advanced Imaging!</h4>
            <div>
                             <a href="book-appointment" class="th-btn" contenteditable="false" style="cursor: pointer;">Online Appointment</a>
                        </div>
        </div>
    </section>
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