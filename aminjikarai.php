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
    <?php include_once("seo.php"); ?>

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
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
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
                <h1 class="breadcumb-title text-white"> Scans World On Aminjikarai</h1>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Aminjikarai</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row flex-row-reverse">

                <div class="col-xl-6 text-center text-xl-start">
                    <div class="title-area mb-32">
                        <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Tamilnadu’s most
                            expansive diagnostic centre featuring state- of -the- art facilities</span>
                        <!-- <h2 class="sec-title">The Best Diagnostic Centre in Chennai</h2> -->
                        <!-- <p class="sec-text">As the best diagnostic center in Chennai, we provide advanced imaging and diagnostic solutions, including PET-CT, MRI, ECG, and comprehensive health checkups. With cutting-edge technology and expert care, we ensure accurate and timely diagnoses for better health outcomes.</p> -->
                    </div>
                    <div class="mb-4 mt-n1">
                        <div class="checklist style2 list-two-column">
                            <!-- <ul>
                                <li><i class="fas fa-shield-check text-theme2"></i> Advanced Imaging</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Comprehensive Health Checkups</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> State-of-the-Art Technology</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Expert Medical Team</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Accurate & Timely Reports</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Patient-Centric Approach</li>
                            </ul> -->
                            <ul>
                                <li><i class="fas fa-shield-check text-theme2"></i> 3 Tesla MRI</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Digital PET CT</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> PET MRI</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> 160 slice Cardiac CT </li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Dual head Gamma camera / nuclear
                                    scans</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Ultrasound</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Mammogram </li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Dexa Scan</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Automated Laboratory</li>
                            </ul>
                        </div>
                         <a href="book-appointment" class="th-btn mt-3">Online Appointment</a>
                    </div>
                    
                    <div>
                       
                    </div>
                </div>
                <div class="col-xl-6 mb-40 mb-xl-0">
                    <div class="img-box7" style="margin: 0px 50px 0px 0px;">
                        <div class="img1">
                            <img data-mask-src="assets/scan-world/centers/aminjikarai-2.jpg"
                                src="assets/scan-world/centers/aminjikarai-2.jpg" alt="About">
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
                        <h3 class="box-title">Aminjikarai Branch</h3>
                        <p class="footer-info">
                            <i class="far fa-location-dot"></i>
                            No. 575, Rakhi Plaza, Poonamallee High Road, Aminjikarai, Chennai – 600 029.
                        </p>
                        <p class="footer-info">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:scansworldonphroad@gmail.com"
                                class="info-box_link">scansworldonphroad@gmail.com</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-phone"></i>
                            <a href="tel:+04435079999" class="info-box_link"> 044 - 3507 9999</a>
                        </p>
                        <p class="footer-info">
                            <i class="fa fa-mobile"></i>
                            <a href="tel:+919445439999" class="info-box_link"> +91 94454 39999</a>
                        </p>
                    </div>
                    <div class="contact-feature">
                        <div class="box-icon">
                            <i class="far fa-clock"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="box-title">Working Hours</h3>
                            <p class="box-text">Open 24×7</p>
                        </div>

                    </div>
                </div>

                <div class="col-xl-8 col-md-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.3969825936556!2d80.22319739999999!3d13.0740084!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5267f5ad2abf15%3A0xd5dd33cca3530db4!2sScans%20World%20-%20Aminjikarai%20%7C%20Use%20Appointment%20link%20from%20our%20Google%20Maps%20profile!5e0!3m2!1sen!2sin!4v1753860924092!5m2!1sen!2sin"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
    <section class="overflow-hidden bg-smoke space" id="service-sec">
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
                        <div class="col-md-3 col-sm-6 col-12">
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
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="ct-scan">
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
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="feature-box text-center">
                                <div class="box-icon">
                                    <img src="assets/scan-world/service-icon/heart-attack.png" alt="icon">
                                </div>
                                <div class="media-body text-start">
                                    <h3 class="box-title">Coronary angiogram</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="#">
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
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="ct-scan">
                                <div class="feature-box text-center">
                                    <div class="box-icon">
                                        <img src="assets/scan-world/service-icon/brain-imaging.png" alt="icon">
                                    </div>
                                    <div class="media-body text-start">
                                        <h3 class="box-title">CT Scan</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="digital-mammography">
                                <div class="feature-box text-center">
                                    <div class="box-icon">
                                        <img src="assets/scan-world/service-icon/mammography.png" alt="icon">
                                    </div>
                                    <div class="media-body text-start">
                                        <h3 class="box-title">Digital Mammography</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="feature-box text-center">
                                <div class="box-icon">
                                    <img src="assets/scan-world/service-icon/radiotherapy.png" alt="icon">
                                </div>
                                <div class="media-body text-start">
                                    <h3 class="box-title">Fibro Scan</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="echo">
                                <div class="feature-box text-center">
                                    <div class="box-icon">
                                        <img src="assets/scan-world/service-icon/monitor.png" alt="icon">
                                    </div>
                                    <div class="media-body text-start">
                                        <h3 class="box-title">ECHO</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="eeg">
                                <div class="feature-box text-center">
                                    <div class="box-icon">
                                        <img src="assets/scan-world/service-icon/eeg.png" alt="icon">
                                    </div>
                                    <div class="media-body text-start">
                                        <h3 class="box-title">EEG</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
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
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="digital-xray">
                                <div class="feature-box text-center">
                                    <div class="box-icon">
                                        <img src="assets/scan-world/service-icon/clinic.png" alt="icon">
                                    </div>
                                    <div class="media-body text-start">
                                        <h3 class="box-title">X-Ray</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="opg">
                                <div class="feature-box text-center">
                                    <div class="box-icon">
                                        <img src="assets/scan-world/service-icon/show.png" alt="icon">
                                    </div>
                                    <div class="media-body text-start">
                                        <h3 class="box-title">OPG</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="colonoscopy-and-endoscopy">
                                <div class="feature-box text-center">
                                    <div class="box-icon">
                                        <img src="assets/scan-world/service-icon/endoscopy.png" alt="icon">
                                    </div>
                                    <div class="media-body text-start">
                                        <h3 class="box-title">Endoscopy</h3>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="feature-box text-center">
                                <div class="box-icon">
                                    <img src="assets/scan-world/service-icon/biopsy.png" alt="icon">
                                </div>
                                <div class="media-body text-start">
                                    <h3 class="box-title">FNAC</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="feature-box text-center">
                                <div class="box-icon">
                                    <img src="assets/scan-world/service-icon/measuring-device.png" alt="icon">
                                </div>
                                <div class="media-body text-start">
                                    <h3 class="box-title">Automated Laboratory</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="master-health-check-packages">
                                <div class="feature-box text-center">
                                    <div class="box-icon">
                                        <img src="assets/scan-world/service-icon/stethoscope.png" alt="icon">
                                    </div>
                                    <div class="media-body text-start">
                                        <h3 class="box-title">Master Health Checkup</h3>
                                    </div>
                                </div>
                            </a>
                        </div>

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
                <div class="swiper th-slider has-shadow" id="teamSlider3"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}'>
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
                                            <h3 class="box-title"><a href="#" class="doctor-detail"
                                                    data-name="<?= htmlspecialchars($row['doctor_name']); ?>"
                                                    data-studies="<?= htmlspecialchars($row['doctor_studies']); ?>"
                                                    data-image="<?= htmlspecialchars($url_config . '/' . $doctor_image_path . $row['doctor_image']); ?>"
                                                    data-content="<?= htmlspecialchars($row['doctor_content']); ?>"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal">
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
                <button data-slider-prev="#teamSlider3" class="slider-arrow slider-prev"><i
                        class="far fa-arrow-left"></i></button>
                <button data-slider-next="#teamSlider3" class="slider-arrow slider-next"><i
                        class="far fa-arrow-right"></i></button>
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
                        <div class="box-icons">
                            <img src="assets/scan-world/centers/team.png" alt="icon">
                        </div>
                        <h3 class="box-title">Experienced Team</h3>

                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icons">
                            <img src="assets/scan-world/centers/master.png" alt="icon">
                        </div>
                        <h3 class="box-title">Master Health Check-ups</h3>

                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icons">
                            <img src="assets/scan-world/centers/lap.png" alt="icon">
                        </div>
                        <h3 class="box-title">Advanced Lab Facilities
                        </h3>

                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icons">
                            <img src="assets/scan-world/centers/open-24-hours.png" alt="icon">
                        </div>
                        <h3 class="box-title">24/7 Service</h3>

                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icons">
                            <img src="assets/scan-world/centers/green-city.png" alt="icon">
                        </div>
                        <h3 class="box-title">Eco Friendly Environment</h3>

                    </div>
                </div>
                <div class="col-xl-4 col-sm-6">
                    <div class="why-feature" data-bg-src="assets/img/bg/why_feature_bg.png">
                        <div class="box-icons">
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
                <a href="book-appointment" class="th-btn" contenteditable="false" style="cursor: pointer;">Online
                    Appointment</a>
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