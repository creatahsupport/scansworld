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
    <?php include_once("seo.php");?>
    
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
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Additional UI enhancements for new content -->

</head>

<body>
<?php include 'header.php'; ?>
<?php include("doctor-details.php") ?>
    <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/breadcrumb-center.png">
        <div class="container">
            <div class="breadcumb-content">
                <h3 class="breadcumb-title text-white"> Diagnostic Centre in Nandanam </h3>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Nandanam</li>
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
                        <h1><span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Diagnostic Centre in Nandanam - Advanced Scans & Imaging Services</span></h1>
                        </div>
                    <!-- Hero Paragraph Block (New Content) -->
                    <p>Finding a trusted diagnostic centre in Nandanam just got easier. At Scansworld, we offer a full range of imaging services  MRI, CT scan, PET CT, ultrasound, X-ray and more all under one roof. Our Nandanam centre is built around one priority: giving you accurate results, quickly, so your doctor can make the right call for your health. 

Scans World Nandanam delivers expert imaging. Accurate reports. Trusted for 15+ years. Open 24/7, 365 days a year. </p>

                    <!-- Existing checklist -->
                    <div class="mb-4 mt-n1">
                        <div class="checklist style2 list-two-column">
                            <ul>
                                <li><i class="fas fa-shield-check text-theme2"></i> 1.5 Tesla MRI</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Whole body PET CT</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> PET MRI</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Low dose CT</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Ultrasound</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Mammogram</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Dexa Scan</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Automated Laboratory</li>
                            </ul>
                        </div>
                        <a href="book-appointment" class="th-btn mt-3">Online Appointment</a>
                    </div>
                </div>
                <div class="col-xl-6 mb-40 mb-xl-0">
                    <div class="img-box7" style="margin: 0px 0px 0px 0px;">
                        <div class="img1">
                            <img data-mask-src="assets/img/normal/about_4_mask.png" src="assets/scan-world/centers/nandanam.png" alt="About">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   

                        <!-- About Scans World Nandanam Section -->
<div class="bg-smoke space" data-bg-src="assets/img/bg/why_bg_3.jpg" style="padding:60px 0;">
    <div class="container">
        <div class="row align-items-center g-5">

            <!-- Content -->
            <div class="col-lg-6">
                <span class="sub-title">
                    <img src="assets/scan-world/icon.webp" alt="about">
                    About Scans World Nandanam
                </span>

                <h2 class="sec-title mb-4">
                    Central Chennai's Most Trusted Diagnostic Centre
                </h2>

                The Nandanam branch on Chamiers Road is Scans World's Central Chennai centre designed to serve the dense mix of residential neighbourhoods and medical communities in and around this part of the city. With its quiet basement-level facility at No. 127, this centre provides a calm, focused environment for patients undergoing everything from routine scans to complex imaging procedures.

<p></p>The centre is equipped for a wide range of imaging needs from a quick digital X-ray to whole-body PET CT and PET MRI, which are among the most advanced diagnostic tools available in India. Every scan is reviewed by Scans World's panel of specialist radiologists, ensuring reports that your doctor can trust and act upon with confidence.


               
            </div>

            <!-- Image -->
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

 
     <!-- Existing Services Section (unchanged dynamic) -->
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
                        <div class="col-md-3 col-sm-6 col-12"><a href="mri-scan"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/wine-barrel.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">MRI Scan </h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="ct-scan"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/ct-scan.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">PET CT</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/heart-attack.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Cardiac CT</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="#"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/ct-scan.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Nuclear Scans</h3></div></div></a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12"><a href="ct-scan"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/brain-imaging.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title"> CT Scan (Multislice)</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="digital-mammography"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/mammography.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Digital Mammography</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/radiotherapy.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Fibro Scan</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="echo"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/monitor.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">ECHO</h3></div></div></a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12"><a href="eeg"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/eeg.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">EEG / EMG / NCS / PFT</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="dexa"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/bone.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">DEXA</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="digital-xray"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/clinic.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Digital X-Ray</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="opg"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/show.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">OPG</h3></div></div></a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12"><a href="colonoscopy-and-endoscopy"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/endoscopy.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Endoscopy / Colonoscopy</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/biopsy.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Image-guided Biopsy / FNAC</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/measuring-device.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Automated Laboratory</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><a href="master-health-check-packages"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/stethoscope.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Master Health Packages</h3></div></div></a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/eeg.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Coronary Angiogram</h3></div></div></a></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/clinic.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Treadmill</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/measuring-device.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Holter</h3></div></div></div>
                        <div class="col-md-3 col-sm-6 col-12"><div class="feature-box text-center"><div class="box-icon"><img src="assets/scan-world/service-icon/bone.png" alt="icon"></div><div class="media-body text-start"><h3 class="box-title">Bone Densitomery</h3></div></div></a></div>
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
                <div class="swiper th-slider has-shadow" id="teamSlider3" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"2"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}'>
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
                                    <h3 class="box-title"><a href="#" class="doctor-detail" data-name="<?= htmlspecialchars($row['doctor_name']); ?>" data-studies="<?= htmlspecialchars($row['doctor_studies']); ?>" data-image="<?= htmlspecialchars($url_config . '/' . $doctor_image_path . $row['doctor_image']); ?>" data-content="<?= htmlspecialchars($row['doctor_content']); ?>" data-bs-toggle="modal" data-bs-target="#exampleModal"><?= htmlspecialchars($row['doctor_name']); ?></a></h3>
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
    <!-- WHY CHOOSE SCANS WORLD NANDANAM Section (New integrated content) -->
    <div class="space" style="padding-top:0;">
        <div class="container">
            <div class="title-area text-center mb-4">
                <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="icon"> Why Choose Scans World Nandanam</span>
                <h2 class="sec-title">We Have 15 Years Experience in Medical Health Services</h2>
               
            </div>
            <div class="enhanced-feature-grid-aminjikarai">
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-map-marker-alt"></i></div>
                    <h4 class="box-title">Heart of Central Chennai</h4>
                    <p>On Chamiers Road, Nandanam one of Chennai's most accessible addresses, reachable from all directions.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="far fa-clock"></i></div>
                    <h4 class="box-title">Open 24×7, 365 days</h4>
                    <p>Emergencies don't follow a timetable. Neither do we round-the-clock scans, every day of the year.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-microscope"></i></div>
                    <h4 class="box-title">Advanced imaging technology</h4>
                    <p>MRI, PET CT, PET MRI, low-dose CT a level of specialisation rare in a single diagnostic centre.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-user-md"></i></div>
                    <h4 class="box-title">Specialist radiologist panel</h4>
                    <p>Neuro, oncoimaging, cardiac, vascular, and paediatric radiologists every report from a genuine specialist.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-subway"></i></div>
                    <h4 class="box-title">Metro accessible</h4>
                    <p>Nandanam Metro Station (Green Line) is within walking distance no parking stress needed.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-parking"></i></div>
                    <h4 class="box-title">Parking available</h4>
                    <p>Dedicated car parking at our basement facility convenient for patients driving in.</p>
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


<!-- FAQ Section -->
<div class="mt-40 faq-wrapper">
    <div class="title-area mb-25">
        <h2 class="sec-title fw-semibold">Frequently Asked Questions</h2>
    </div>

    <div class="accordion" id="faqAccordion">

        <!-- FAQ 1 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    1. Is Scans World Nandanam open 24 hours?
                </button>
            </div>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Yes. Our Nandanam centre on Chamiers Road is open 24 hours a day, 7 days a week,
                        including all public holidays. Whether it is an urgent scan late at night or an
                        early-morning appointment, we are always available.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    2. What is the address of Scans World Nandanam?
                </button>
            </div>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        We are located at <strong>No. 127, Basement, Chamiers Road, <a href="nandanam.php">Nandanam</a>,
                        Chennai – 600 035.</strong> The centre is easily reachable by Nandanam Metro
                        Station (Green Line), MTC bus, auto, and personal vehicle with dedicated
                        parking on site.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    3. Is PET CT available at Scans World Nandanam?
                </button>
            </div>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Yes. Whole-body <a href="pet-ct.php">PET CT</a> is available at our Nandanam centre, primarily used
                        for cancer diagnosis, staging and treatment response monitoring. We also
                        offer PET MRI, combining metabolic imaging with high-resolution structural
                        detail for greater diagnostic precision.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    4. Is MRI available at Scans World Nandanam?
                </button>
            </div>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Yes. MRI scanning is available at our Nandanam centre, covering brain,
                        spine, musculoskeletal, abdominal and whole-body imaging. All reports are
                        reviewed by our specialist radiologist panel.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 5 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingFive">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                    5. How far is Scans World Nandanam from T. Nagar?
                </button>
            </div>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Our Chamiers Road centre is approximately <strong>2 kilometres</strong> from
                        T. Nagar, around a <strong>5 to 10 minute drive</strong>. It is also easily
                        reachable by auto or directly from Nandanam Metro Station on the Green Line.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 6 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingSix">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                    6. How far is Scans World Nandanam from Adyar?
                </button>
            </div>
            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Our<a href="nandanam.php"> Nandanam centre on Chamiers Road </a>is approximately
                        <strong>3 kilometres</strong> from Adyar, about a
                        <strong>10 minute drive</strong>. Chamiers Road directly connects
                        Nandanam and Adyar, making travel quick and convenient.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 7 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingSeven">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                    7. How soon will I receive my scan report?
                </button>
            </div>
            <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        Most reports are ready the same day or the following day. For urgent cases,
                        please inform our front desk team during registration and we will prioritise
                        your report accordingly.
                    </p>
                </div>
            </div>
        </div>

        <!-- FAQ 8 -->
        <div class="accordion-card">
            <div class="accordion-header" id="headingEight">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                    8. Which is the best diagnostic centre near Mylapore or Alwarpet?
                </button>
            </div>
            <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                    <p class="faq-text">
                        <a href="https://scansworldonchamiersroad.com">Scans World </a> Nandanam on Chamiers Road is one of the closest and most
                        comprehensive diagnostic centres for residents of Mylapore, Alwarpet,
                        Teynampet, Gopalapuram and Saidapet. We offer MRI, PET CT, CT Scan,
                        Ultrasound, Laboratory Tests and more, with 24/7 service.
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
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
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
    <script>
        $(function() { $('[data-toggle="collapse"]').on('click', function() { var target = $(this).data('target'); $(target).collapse('toggle'); }); });
    </script>
</body>
</html>