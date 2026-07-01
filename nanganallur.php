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
</head>

<body>
<?php include 'header.php'; ?>
<?php include("doctor-details.php") ?>
    <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/breadcrumb.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title text-white"> Scans World on Nanganallur</h1>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Nanganallur</li>
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
                        <h1><span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape" >Diagnostic Centre in Nanganallur – MRI, CT, PET-CT & Imaging Services</span></h1>
                        <p>Getting the right scan at the right time can change everything and it shouldn't mean a long drive across the city. Scans World Nanganallur brings specialist-level diagnostic services to South Chennai, so you get the same advanced imaging, the same expert radiologist reports, and the same quality of care you would expect from any leading diagnostic centre  right here, close to home.
</p><p>Whether your doctor has referred you for an MRI, CT scan,<a href="color-doppler"> ultrasound</a>, mammogram, blood test, or a full master health check-up  everything is available under one roof, open 24 hours a day, every day of the year
</p>
                    </div>
                    <!-- Existing checklist -->
                    <div class="mb-4 mt-n1">
                        <div class="checklist style2 list-two-column">
                            <ul>
                                <li><i class="fas fa-shield-check text-theme2"></i> 1.5 Tesla MRI</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> 80 slice CT</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Ultrasound</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Mammogram</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Automated Laboratory</li>
                                <li><i class="fas fa-shield-check text-theme2"></i> Health Check up</li>
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
                            <img data-mask-src="assets/img/normal/about_4_mask.png" src="assets/scan-world/centers/nanganallur.webp" alt="About" style="width:100%; height:550px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!-- About Scans World Nanganallur + Location Card (enhanced) -->
    <div class="bg-smoke space" data-bg-src="assets/img/bg/why_bg_3.jpg">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="about"> About Scans World Nanganallur</span>
                    <p>This centre is strategically placed to serve the rapidly growing residential communities of South Chennai. The Nanganallur branch brings <a href="https://scansworldonchamiersroad.com/">Scans World's </a>trusted diagnostics  the same technology, the same radiologist expertise, the same quality standards  to patients who previously had to travel far for specialist-level imaging.</p>
                    <p>The centre is designed to be welcoming and efficient: a comfortable waiting area, a smooth registration process, and a trained team that guides every patient through their scan with care. For patients requiring advanced imaging like <a href="pet-ct">PET CT </a>or nuclear scans, our Aminjikarai flagship centre is just a short drive away and our team helps coordinate seamlessly.</p>
                    
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

    <!-- WHY CHOOSE SCANS WORLD NANGANALLUR Section (New integrated content) -->
    <div class="space" style="padding-top:0;">
        <div class="container">
            <div class="title-area text-center mb-4">
                <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="icon"> Why Choose Scans World Nanganallur</span>
            </div>
            <div class="enhanced-feature-grid-aminjikarai">
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="far fa-clock"></i></div>
                    <h4 class="box-title">Available 24×7, 365 days</h4>
                    <p>Emergency scans, night-time results, and planned appointments</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-microscope"></i></div>
                    <h4 class="box-title">1.5 & 3 Tesla MRI & 128/64 slice CT</h4>
                    <p>Advanced imaging for Neuro, Ortho, Chest, Abdomen and more.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-user-md"></i></div>
                    <h4 class="box-title">Expert Radiologist Panel</h4>
                    <p>Reports reviewed by specialists in neuro, onco, cardiac, vascular and pediatric imaging.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-chart-line"></i></div>
                    <h4 class="box-title">15+ years of trusted care</h4>
                    <p>A name South Chennai families count on for reliable diagnostics.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-vial"></i></div>
                    <h4 class="box-title">Automated laboratory</h4>
                    <p>Quick and precise results for full blood tests and biochemistry panels.</p>
                </div>
                <div class="feature-card-enhanced">
                    <div class="feature-icon-enhanced"><i class="fas fa-parking"></i></div>
                    <h4 class="box-title">Lots of parking</h4>
                    <p>Reserved parking at our 29th Street facility — stress-free visit.</p>
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
    <div class="space bg-smoke">
        <div class="container">
            <div class="title-area text-center">
                <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="faq"> Frequently Asked Questions</span>
                <h2 class="sec-title">Everything you need to know</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="accordion faq-accordion" id="faqAccordionNanganallur">
                        <div class="card"><div class="card-header"><button class="btn btn-link btn-block text-start" type="button" data-toggle="collapse" data-target="#faqN1">Q: Is Scans World Nanganallur open 24 hours?</button></div><div id="faqN1" class="collapse show" data-parent="#faqAccordionNanganallur"><div class="card-body">Yes. Our Nanganallur centre on 29th Street is open 24 hours a day, 7 days a week, including Sundays and public holidays. You can come in for an emergency scan or a pre planned check-up at any time.</div></div></div>
                        <div class="card"><div class="card-header"><button class="btn btn-link btn-block text-start collapsed" type="button" data-toggle="collapse" data-target="#faqN2">Q: What is the address of Scans World Nanganallur?</button></div><div id="faqN2" class="collapse" data-parent="#faqAccordionNanganallur"><div class="card-body">We are located at No. 19, 29th Street, Nanganallur, Chennai – 600 061. The centre is easily reachable by auto, bus and personal vehicle. Parking is available on site.</div></div></div>
                        <div class="card"><div class="card-header"><button class="btn btn-link btn-block text-start collapsed" type="button" data-toggle="collapse" data-target="#faqN3">Q: Is MRI available at Scans World Nanganallur?</button></div><div id="faqN3" class="collapse" data-parent="#faqAccordionNanganallur"><div class="card-body">Yes. MRI scanning is available at our Nanganallur centre. For patients requiring our 3 Tesla high-field MRI, our <a href="aminjikarai">Aminjikarai </a>flagship centre is equipped with this advanced system and is easily accessible.</div></div></div>
                        <div class="card"><div class="card-header"><button class="btn btn-link btn-block text-start collapsed" type="button" data-toggle="collapse" data-target="#faqN4">Q: Are blood tests and lab services available at Nanganallur?</button></div><div id="faqN4" class="collapse" data-parent="#faqAccordionNanganallur"><div class="card-body">Yes. Our Nanganallur centre has a fully automated laboratory offering blood tests, CBC, lipid profile, thyroid, liver function, kidney function, and other investigations with fast turnaround and accurate results.</div></div></div>
                        <div class="card"><div class="card-header"><button class="btn btn-link btn-block text-start collapsed" type="button" data-toggle="collapse" data-target="#faqN5">Q: Do I need an appointment, or can I walk in?</button></div><div id="faqN5" class="collapse" data-parent="#faqAccordionNanganallur"><div class="card-body">Walk-ins are welcome at Scans World Nanganallur. For advanced scans like MRI, CT or cardiac imaging, booking an appointment in advance ensures your preferred time slot. Call +91 72000 48999 to reserve.</div></div></div>
                        <div class="card"><div class="card-header"><button class="btn btn-link btn-block text-start collapsed" type="button" data-toggle="collapse" data-target="#faqN6">Q: How soon will I receive my scan report?</button></div><div id="faqN6" class="collapse" data-parent="#faqAccordionNanganallur"><div class="card-body">Most scan reports are available the same day or the following day. If you need an urgent report, please inform our front desk team at registration and we will prioritise accordingly.</div></div></div>
                        <div class="card"><div class="card-header"><button class="btn btn-link btn-block text-start collapsed" type="button" data-toggle="collapse" data-target="#faqN7">Q: Is digital mammography available at Nanganallur?</button></div><div id="faqN7" class="collapse" data-parent="#faqAccordionNanganallur"><div class="card-body">Yes. Digital mammography for breast cancer screening and diagnosis is available at our Nanganallur centre. We recommend all women above 40 to include a mammogram as part of their annual health check-up.</div></div></div>
                        <div class="card"><div class="card-header"><button class="btn btn-link btn-block text-start collapsed" type="button" data-toggle="collapse" data-target="#faqN8">Q: Which is the best diagnostic centre near Pallavaram or Chromepet?</button></div><div id="faqN8" class="collapse" data-parent="#faqAccordionNanganallur"><div class="card-body"><a href="nanganallur">Scans World Nanganallur</a>, located on 29th Street, is one of the closest and most comprehensive diagnostic centres for residents of Pallavaram, Chromepet, Pammal, Tambaram, Adambakkam, and Madipakkam offering MRI, CT, ultrasound, lab tests and more under one roof, open 24/7.</div></div></div>
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
            <div><a href="book-appointment" class="th-btn" contenteditable="false" style="cursor: pointer;">Book Mow</a></div>
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
    <script>
        $(function() { $('[data-toggle="collapse"]').on('click', function() { var target = $(this).data('target'); $(target).collapse('toggle'); }); });
    </script>
</body>
</html>