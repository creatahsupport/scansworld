<?php
include("includes/config.php");

// Fetch latest 20 doctors
$doctor_image_path = "uploads/doctor_images/";
$doctors_query = "SELECT * FROM doctors WHERE del_i = 0 ORDER BY id ASC LIMIT 20";
$latest_doctors = mysqli_query($con, $doctors_query);
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
    <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>
    <?php include 'header.php'; ?>
    <?php include("doctor-details.php") ?>
    <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/breadcrumb.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title text-white"> Scans World at Vellore</h1>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Vellore</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- About Section with integrated Hero Paragraph & Enhanced Content -->
    <div class="overflow-hidden space" id="about-sec">
        <div class="container">
            <div class="row flex-row-reverse">
                <div class="col-xl-6 text-center text-xl-start">
                    <div class="title-area mb-32">
                        <h1><span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Diagnostic Centre in Vellore Advanced Scans & Imaging Services </span></h1>
                       
                    </div>
                    <!-- Hero Paragraph Block (New Content) -->
                    <p>Vellore is one of Tamil Nadu's most important medical destinations and residents deserve access to diagnostic services that match that standard. <strong>Scans World Vellore</strong> brings Chennai-level advanced imaging and laboratory services directly to Vellore — no long travel, no compromise on quality.</p>
                       <p> Whether you need an MRI, CT scan, <a href="pet-ct">PET CT</a>, ultrasound, mammogram, blood test, or a full master health check-up — Scans World Vellore has it all under one roof, with the same expert radiologist panel and quality standards that have made Scans World a trusted name in diagnostics for over 15 years. Open 24 hours a day, 7 days a week.</p>
                    
                    <!-- Existing checklist -->
                    <div class="mb-4 mt-n1">
                        <div class="checklist style2 list-two-column">
                            <ul>
                                <li><i class="fas fa-shield-check text-theme2"></i> MRI Scan</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> CT Scan</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Ultra Sound</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Digital X-Ray</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Mammogram</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Blood Test</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Lab</li>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <a href="book-appointment" class="th-btn mb-3">Online Appointment</a>
                    </div>
                </div>
                <div class="col-xl-6 mb-40 mb-xl-0">
                    <div class="img-box7" style="margin: 0px 0px 0px 0px;">
                        <div class="img1">
                            <img data-mask-src="assets/img/normal/about_4_mask.png"
                                src="assets/scan-world/centers/vellore.webp" alt="About">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- About Scans World Vellore + Location Card -->
    <div class="bg-smoke space" data-bg-src="assets/img/bg/why_bg_3.jpg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="about"> About Scans World Vellore</span>
                    
                    <p>Vellore has long been one of Tamil Nadu's most important centres for medical care and patients who travel here for specialist consultations deserve access to diagnostic services that match that standard. Scans World Vellore was established with exactly that in mind: bringing advanced imaging and laboratory services to the city, so patients no longer need to travel to Chennai for a quality scan.</p>
                    <p>From a routine blood test to a whole-body <a href="pet-ct">PET CT</a>, every service at our Vellore centre is delivered with the same quality standards as our Chennai branches. Every scan is reviewed by our panel of specialist radiologists including neuro, oncoimaging, cardiac, vascular, and paediatric imaging experts ensuring reports that are accurate, detailed, and clinically useful for your doctor.</p>
                    <b><p>Open 24 hours a day, 7 days a week. Always here when you need us.</p></b>
                </div>
            <div class="col-lg-6">
                <div class="about-img">
                    <img src="assets\img\gallery\about.png"
                         alt="Scans World Nandanam"
                         class="img-fluid rounded shadow">
                </div>
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
                        <div class="col-md-3 col-sm-6 col-12"><a href="mri-scan"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/wine-barrel.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">MRI</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="ct-scan"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/ct-scan.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">PET CT</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/heart-attack.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Coronary angiogram</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="#"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/ct-scan.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Nuclear Scans</h3></div></div></a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12"><a href="ct-scan"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/brain-imaging.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">CT Scan</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="digital-mammography"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/mammography.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Digital Mammography</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/radiotherapy.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Fibro Scan</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="echo"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/monitor.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">ECHO</h3></div></div></a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12"><a href="eeg"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/eeg.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">EEG</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="dexa"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/bone.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">DEXA</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="digital-xray"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/clinic.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">X-Ray</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="opg"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/show.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">OPG</h3></div></div></a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12"><a href="colonoscopy-and-endoscopy"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/endoscopy.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Endoscopy</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/biopsy.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">FNAC</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/measuring-device.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Automated Laboratory</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="master-health-check-packages"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/stethoscope.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Master Health Checkup</h3></div></div></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Meet Our Experts (dynamic unchanged) -->
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
                            <div class="col-12"><div class="text-center">No Data Found.</div></div>
                        <?php } ?>
                    </div>
                </div>
                <button data-slider-prev="#teamSlider3" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>
                <button data-slider-next="#teamSlider3" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>
            </div>
        </div>
    </section>

    <!-- WHY CHOOSE SCANS WORLD VELLORE Section (New integrated content) -->
    <div class="space" style="padding-top:0;">
        <div class="container">
            <div class="title-area text-center mb-4">
                <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="icon"> Why Choose Scans World for Your Diagnostics in Vellore</span>
              
            </div>
            <div class="enhanced-feature-grid-aminjikarai">
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-microscope"></i></div>
                    <h4 class="box-title">Chennai-level advanced imaging</h4>
                    <p>The same technology and quality standards as our Chennai flagship — right here in Vellore.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="far fa-clock"></i></div>
                    <h4 class="box-title">Open 24×7, 365 days</h4>
                    <p>Round-the-clock availability for emergency scans, late-night reports, and planned check-ups.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-user-md"></i></div>
                    <h4 class="box-title">Expert radiologist panel</h4>
                    <p>Reports reviewed by specialist radiologists in neuro, onco, cardiac, vascular, and paediatric imaging.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-building"></i></div>
                    <h4 class="box-title">All-in-one diagnostic centre</h4>
                    <p>MRI, CT, PET CT, ultrasound, mammography, lab, ECG — no need to visit multiple centres.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-vial"></i></div>
                    <h4 class="box-title">Automated laboratory</h4>
                    <p>Full blood tests and biochemistry panels with fast, accurate results.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-parking"></i></div>
                    <h4 class="box-title">Ample parking</h4>
                    <p>Dedicated parking at our Thottapalayam facility.</p>
                </div>
            </div>
        </div>
    </div>
  <!-- Process section (existing) -->
    <section class="space">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="Icon">Work Process</span>
                <h2 class="sec-title">Seamless Scan Process for <br>Accurate Diagnosis</h2>
            </div>
            <div class="process-card-wrap">
                <div class="process-card"><div class="box-img"><div class="img"><img src="assets/scan-world/centers/step-1.webp" alt="icon"></div><p class="box-number">01</p></div><h3 class="box-title">Book Appointment</h3><p class="box-text">Schedule your scan at your convenience with a hassle-free booking process.</p></div>
                <div class="process-card"><div class="box-img"><div class="img"><img src="assets/scan-world/centers/step-2.webp" alt="icon"></div><p class="box-number">02</p></div><h3 class="box-title">Undergo Scan</h3><p class="box-text">Experience high-quality imaging with advanced scanning technology.</p></div>
                <div class="process-card"><div class="box-img"><div class="img"><img src="assets/scan-world/centers/step-3.webp" alt="icon"></div><p class="box-number">03</p></div><h3 class="box-title">Receive Report</h3><p class="box-text">Get precise and detailed <br>reports analyzed by <br>experts.</p></div>
                <div class="process-card"><div class="box-img"><div class="img"><img src="assets/scan-world/centers/step-4.webp" alt="icon"></div><p class="box-number">04</p></div><h3 class="box-title">Ongoing Care</h3><p class="box-text">Advanced imaging for precise diagnosis and<br> care.</p></div>
            </div>
        </div>
    </section>


    <section class="testimonial-section">
    <div class="container">

        <div class="title-area text-center">
            <span class="sub-title">
                <img src="assets/scan-world/icon.webp" alt="">
                Testimonials
            </span>

            <h2 class="sec-title">What Our Patients Say</h2>

            <p>
                Trusted by thousands of patients across Chennai for accurate diagnosis and compassionate care.
            </p>
        </div>

        <div class="row">

            <!-- Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card">
                    <div class="quote">
                        <i class="fas fa-quote-left"></i>
                    </div>

                    <p>
                        The diagnostic center in Chennai is very professional and well kept. The reports came on time and my doctor liked how clear the results were. You can tell that they have experienced radiologists and high tech equipment.
                    </p>

                    <div class="rating">
                        ★★★★★
                    </div>

                    <div class="patient">
                        <img src="assets\img\icon\icon.jpg">
                        <div>
                            <h5>Karthick S</h5>
                            <span>Nandanam</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card">
                    <div class="quote">
                        <i class="fas fa-quote-left"></i>
                    </div>

                    <p>
                        Very good experience here in Scans World. Staff are so helpful as well as responsive. In fact friendly as well. Even if we have any concerns after coming home, they’re responding well over the phone and co ordinating. Highly recommend.
                    </p>

                    <div class="rating">
                        ★★★★★
                    </div>

                    <div class="patient">
                        <img src="assets\img\icon\icon.jpg">
                        <div>
                            <h5>Remy Leo</h5>
                            <span>Chennai</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="testimonial-card">
                    <div class="quote">
                        <i class="fas fa-quote-left"></i>
                    </div>

                    <p>
                        Best experience at Scans World at Vellore. The staffs are very professional, and the report was accurate and delivered quickly. Highly recommend this diagnostic centre in Vellore for reliable imaging services.
                    </p>

                    <div class="rating">
                        ★★★★★
                    </div>

                    <div class="patient">
                        <img src="assets\img\icon\icon.jpg">
                        <div>
                            <h5>Santhosh</h5>
                            <span>Vellore</span>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </div>
</section>
  

    <!-- FAQ Section (New from provided content) -->
    <!-- FAQ Section -->
<div class="mt-40 faq-wrapper">
    <div class="title-area mb-25">
        <h2 class="sec-title fw-semibold">Frequently Asked Questions</h2>
    </div>

    <div class="accordion" id="faqAccordion">

        <!-- FAQ 1 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="false" aria-controls="collapseOne">
                    1. Which is the best diagnostic centre in Vellore?
                </button>
            </div>
            <div id="collapseOne" class="accordion-collapse collapse"
                aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Scans World Vellore at Dharmaraja Koil Street, Thottapalayam is one of the most comprehensive diagnostic centres in Vellore, offering MRI, PET CT, CT Scan, Ultrasound, Digital Mammography, Automated Laboratory and more under one roof, open 24/7. Reports are reviewed by the same specialist radiologist panel serving our Chennai branches.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                    aria-expanded="false" aria-controls="collapseTwo">
                    2. What scans are available at Scans World Vellore?
                </button>
            </div>
            <div id="collapseTwo" class="accordion-collapse collapse"
                aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Scans World Vellore offers MRI, PET CT, CT Scan, Cardiac CT, Nuclear Scans, Digital Mammography, Ultrasound, FibroScan,
                        <a href="color-doppler">Color Doppler</a>, ECHO, ECG, EEG, DEXA, Digital X-Ray, OPG, Endoscopy, Image-Guided Biopsy, Automated Laboratory and Master Health Packages, all under one roof at Thottapalayam, open 24/7.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseThree"
                    aria-expanded="false" aria-controls="collapseThree">
                    3. How far is Scans World Vellore from Katpadi Railway Station?
                </button>
            </div>
            <div id="collapseThree" class="accordion-collapse collapse"
                aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Scans World Vellore at Thottapalayam is approximately
                        <strong>5 kilometres</strong> from Katpadi Junction—around a
                        <strong>10 to 15 minute drive</strong> by auto or cab.
                        Katpadi is the main railway station serving Vellore, making our
                        centre easily accessible for patients travelling from Chennai,
                        Bangalore and other cities.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseFour"
                    aria-expanded="false" aria-controls="collapseFour">
                    4. Where is Scans World Vellore located?
                </button>
            </div>
            <div id="collapseFour" class="accordion-collapse collapse"
                aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Scans World Vellore is located at
                        <strong>No. 54/3, Dharmaraja Koil Street, Thottapalayam, Vellore – 632 004.</strong>
                        The centre is centrally located and easily reachable from all parts of Vellore and nearby towns like Katpadi, Ranipet, Ambur and Gudiyatham. Parking is available on site. Call
                        <strong>+91 99447 17999</strong>.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 5 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseFive"
                    aria-expanded="false" aria-controls="collapseFive">
                    5. How do I book a scan at Scans World Vellore?
                </button>
            </div>
            <div id="collapseFive" class="accordion-collapse collapse"
                aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        You can book a scan at
                        <a href="vellore">Scans World Vellore</a>
                        by calling or WhatsApping
                        <strong>+91 99447 17999</strong>, using our online appointment form, or by walking in directly—we are open 24 hours a day, 7 days a week. For advanced scans like MRI or PET CT, prior booking ensures your preferred time slot is available.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 6 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed" type="button"
                    data-bs-toggle="collapse" data-bs-target="#collapseSix"
                    aria-expanded="false" aria-controls="collapseSix">
                    6. What are the working hours of Scans World Vellore?
                </button>
            </div>
            <div id="collapseSix" class="accordion-collapse collapse"
                aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Scans World Vellore is open
                        <strong>24 hours a day, 7 days a week</strong>, including Sundays and public holidays. Whether you need an urgent scan late at night or a planned health check-up, our team is always available.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

    <!-- Final CTA Section (original) -->
    <section class="cta-sec7 space" data-bg-src="assets/scan-world/cta.png">
        <div class="container">
            <h2 class="sec-title mb-md-4 mb-2">Need a Scan for Diagnosis?</h2>
            <h4 class="text-theme fw-semibold mb-4 mb-md-5">Get Accurate Results with Advanced Imaging!</h4>
            <div><a href="book-appointment" class="th-btn" contenteditable="false" style="cursor: pointer;">Book Now</a></div>
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
    <script>
        $(function() { $('[data-toggle="collapse"]').on('click', function() { var target = $(this).data('target'); $(target).collapse('toggle'); }); });
    </script>
</body>
</html>