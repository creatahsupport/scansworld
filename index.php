<?php
include("includes/config.php");

// Fetch latest 3 testimonials
$testimonial_query = "SELECT * FROM testimonial WHERE del_i = 0 ORDER BY id DESC LIMIT 50";
$latest_testimonial = mysqli_query($con, $testimonial_query);

// Fetch latest 20 blogs
$blog_image_path = "uploads/blog/";
$blog_query = "SELECT * FROM blog WHERE del_i = 0 ORDER BY id DESC LIMIT 20";
$latest_blog = mysqli_query($con, $blog_query);

// ✅ Fetch only active doctors (status = 1)
$doctor_image_path = "uploads/doctor_images/";
$doctors_query = "SELECT * FROM doctors WHERE del_i = 0 AND status = 1 ORDER BY id ASC LIMIT 20";
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

  <?php include("header.php") ?>
  <?php include("banner.php") ?>
  <?php include("doctor-details.php") ?>
  <div class="space" id="about-sec">
    <div class="shape-mockup" data-top="0" data-right="0"><img src="assets/img/shape/pattern_shape_1.png" alt="shape"></div>

    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-6 mb-30 mb-xl-0">
          <div class="img-box6">
            <div class="img1">
              <img src="assets/scan-world/services/mri.jpg" alt="About">
            </div>
          </div>
        </div>
        <div class="col-xl-6">
          <div class="ps-xxl-4 ms-xl-2 text-center text-xl-start">
            <div class="title-area mb-32">
              <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Scans World – Chennai’s Trusted Diagnostic Centre for 15+ Years</span>
              <!-- <h2 class="sec-title">About Scans World</h2> -->
              <p class="sec-text">Delivering fast, accurate, and affordable medical imaging, Scans World is the preferred choice for patients and clinicians alike.</p>
            </div>
            <div class="mb-4 mt-n1">
              <div class="checklist style2">
                <ul>
                  <li><i class="fas fa-shield-check text-theme2"></i> Advanced Technology:  Equipped with 160-slice Digital PET CT, 3T MRI, and Dual-head Gamma Camera, we ensure unmatched diagnostic precision to guide effective treatments.</li>
                  <li><i class="fas fa-shield-check text-theme2"></i> Trusted Expertise:  Our experienced radiologists and skilled technicians provide accurate interpretations with a focus on clinical excellence.</li>
                  <li><i class="fas fa-shield-check text-theme2"></i> Affordable, Patient-Centric Care: We combine cutting-edge diagnostics with cost-effective pricing and a compassionate approach, ensuring every patient feels supported and informed.</li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="space pt-0" id="testi-sec">
    <div class="container">
      <div class="title-area text-center">
        <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Our Centers</span>
        <h2 class="sec-title">Find Scans World near you</h2>
      </div>
      <div class="swiper th-slider" id="testiSlide1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
        <div class="swiper-wrapper">
        <div class="swiper-slide">
            <div class="pe-xxl-5">
              <div class="faq-img2">
                <img src="assets/scan-world/centers/aminjikarai-3.webp" alt="centers">
                <div class="box-content">
                  <h3 class="box-title">Aminjikarai</h3>
                  <div>
                    <a href="aminjikarai" class="th-btn center">Visit Center</a>
                  </div>
                  <div class="box-review pt-3"><a href="https://www.google.com/search?sca_esv=fd0b6290a00de74f&rlz=1C1ONGR_enIN1108IN1108&sxsrf=AHTn8zroU6EA_zsj-ous1dsu0KRX7dm1iw:1743428479403&si=APYL9bvoDGWmsM6h2lfKzIb8LfQg_oNQyUOQgna9TyfQHAoqUsAJ88OFDCk9LalUFLl2rWU_SW9-tMZwtOIRM68bNyS1csWJHMOfvmKN0Scr_m84UUpqnX6SY3dPGEzZNtYtMdDFiNW8&q=Scans+World+Reviews&sa=X&ved=2ahUKEwiW7dKZubSMAxWnRmcHHcvlI3YQ0bkNegQIMRAE&biw=1536&bih=738&dpr=1.25#lrd=0x3a526642b433cbb1:0x3c4faf28d0dc443c,3,,,," target="_blank">
                      <div class="rating d-flex align-items-center">
                        <span class="review-count">4.7</span>
                        <div class="da-star-rating">
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star half-star"><svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <defs>
                                <linearGradient id="grad">
                                  <stop offset="70%" stop-color="gold" />
                                  <stop offset="70%" stop-color="gray" />
                                </linearGradient>
                              </defs>
                              <path fill="url(#grad)" d="M12 2l3 7h7l-5 5 2 7-7-4-7 4 2-7-5-5h7z" />
                            </svg>
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="pe-xxl-5">
              <div class="faq-img2">
                <img src="assets/scan-world/centers/img-1.png" alt="centers">
                <div class="box-content">
                  <h3 class="box-title">Nandanam</h3>
                  <div>
                    <a href="nandanam" class="th-btn center">Visit Center</a>
                  </div>
                  <div class="box-review pt-3"><a href="https://www.google.com/search?sca_esv=fd0b6290a00de74f&rlz=1C1ONGR_enIN1108IN1108&sxsrf=AHTn8zoPyVrHXQO7GacX4BW2Vi5_JNV1QQ:1743427997492&si=APYL9bs7Hg2KMLB-4tSoTdxuOx8BdRvHbByC_AuVpNyh0x2KzdMFUpKq_i8DRzY729siRYIPIkNTSiYprNV3G6XBPQW7eTneJXsoxV72ECoelezBbms9AnpyD0gP_nadh4eA-yb-XxMYExqbZF7kYipuSfqni0uhdw%3D%3D&q=Scans+World+-+Chamiers+Road+Reviews&sa=X&ved=2ahUKEwiUre2zt7SMAxV3TWwGHTYoKhcQ0bkNegQIHhAE&biw=1536&bih=738&dpr=1.25#lrd=0x3a5267bff3c22b3f:0xe1dfa4f6968d1dc1,3,,,," target="_blank">
                      <div class="rating d-flex align-items-center">
                        <span class="review-count">4.8</span>
                        <div class="da-star-rating">
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star half-star"><svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <defs>
                                <linearGradient id="grad">
                                  <stop offset="70%" stop-color="gold" />
                                  <stop offset="70%" stop-color="gray" />
                                </linearGradient>
                              </defs>
                              <path fill="url(#grad)" d="M12 2l3 7h7l-5 5 2 7-7-4-7 4 2-7-5-5h7z" />
                            </svg>
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="pe-xxl-5">
              <div class="faq-img2">
                <img src="assets/scan-world/centers/nanganallur.webp" alt="centers">
                <div class="box-content">
                  <h3 class="box-title">Nanganallur</h3>
                  <div>
                    <a href="nanganallur" class="th-btn center">Visit Center</a>
                  </div>
                  <div class="box-review pt-3"><a href="https://www.google.com/search?sca_esv=fd0b6290a00de74f&rlz=1C1ONGR_enIN1108IN1108&sxsrf=AHTn8zoPyVrHXQO7GacX4BW2Vi5_JNV1QQ:1743427997492&si=APYL9bs7Hg2KMLB-4tSoTdxuOx8BdRvHbByC_AuVpNyh0x2KzdMFUpKq_i8DRzY729siRYIPIkNTSiYprNV3G6XBPQW7eTneJXsoxV72ECoelezBbms9AnpyD0gP_nadh4eA-yb-XxMYExqbZF7kYipuSfqni0uhdw%3D%3D&q=Scans+World+-+Chamiers+Road+Reviews&sa=X&ved=2ahUKEwiUre2zt7SMAxV3TWwGHTYoKhcQ0bkNegQIHhAE&biw=1536&bih=738&dpr=1.25#lrd=0x3a5267bff3c22b3f:0xe1dfa4f6968d1dc1,3,,,," target="_blank">
                      <div class="rating d-flex align-items-center">
                        <span class="review-count">4.6</span>
                        <div class="da-star-rating">
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star half-star"><svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <defs>
                                <linearGradient id="grad">
                                  <stop offset="70%" stop-color="gold" />
                                  <stop offset="70%" stop-color="gray" />
                                </linearGradient>
                              </defs>
                              <path fill="url(#grad)" d="M12 2l3 7h7l-5 5 2 7-7-4-7 4 2-7-5-5h7z" />
                            </svg>
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
      
          <!-- <div class="swiper-slide">
            <div class="pe-xxl-5">
              <div class="faq-img2">
                <img src="assets/scan-world/centers/mylapore.png" alt="centers">
                <div class="box-content">
                  <h3 class="box-title">Mylapore</h3>
                  <div>
                    <a href="mylapore" class="th-btn center">Visit Center</a>
                  </div>
                  <div class="box-review pt-3"><a href="https://www.google.com/search?q=Scans+World+-+Mylapore&sca_esv=fd0b6290a00de74f&rlz=1C1ONGR_enIN1108IN1108&biw=1536&bih=738&sxsrf=AHTn8zrTorVx5uLCgs8RGRmlw5Wnn-ZbFA%3A1743428552776&ei=yJvqZ66QL_W7seMP05iYsAw&ved=0ahUKEwiulNG8ubSMAxX1XWwGHVMMBsYQ4dUDCBA&uact=5&oq=Scans+World+-+Mylapore&gs_lp=Egxnd3Mtd2l6LXNlcnAiFlNjYW5zIFdvcmxkIC0gTXlsYXBvcmUyChAAGLADGNYEGEcyChAAGLADGNYEGEcyChAAGLADGNYEGEcyChAAGLADGNYEGEcyChAAGLADGNYEGEcyChAAGLADGNYEGEcyDRAAGLADGNYEGEcYyQMyChAAGLADGNYEGEcyDhAAGIAEGLADGJIDGIoFSPeEA1AAWABwAXgAkAEAmAFuoAFuqgEDMC4xuAEDyAEAmAIBoAIImAMAiAYBkAYJkgcBMaAH-QU&sclient=gws-wiz-serp#lrd=0x3a526642b433cbb1:0x3c4faf28d0dc443c,1,,,," target="_blank">
                      <div class="rating d-flex align-items-center">
                        <span class="review-count">4.6</span>
                        <div class="da-star-rating">
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star half-star"><svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <defs>
                                <linearGradient id="grad">
                                  <stop offset="70%" stop-color="gold" />
                                  <stop offset="70%" stop-color="gray" />
                                </linearGradient>
                              </defs>
                              <path fill="url(#grad)" d="M12 2l3 7h7l-5 5 2 7-7-4-7 4 2-7-5-5h7z" />
                            </svg>
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>

                </div>
              </div>
            </div>
          </div> -->
          <!-- <div class="swiper-slide">
            <div class="pe-xxl-5">
              <div class="faq-img2">
                <img src="assets/scan-world/centers/nanganallur.webp" alt="faq">
                <div class="box-content">
                  <h3 class="box-title">Nungambakkam</h3>
                  <div>
                    <a href="nungambakkam" class="th-btn">Visit Center</a>
                  </div>
                  <div class="box-review pt-3"><a href="https://www.google.com/search?sca_esv=fd0b6290a00de74f&rlz=1C1ONGR_enIN1108IN1108&sxsrf=AHTn8zrhxNfY-5eErebJR8zJA6FFpgY2NA:1743428795579&si=APYL9bvoDGWmsM6h2lfKzIb8LfQg_oNQyUOQgna9TyfQHAoqUsAJ88OFDCk9LalUFLl2rWU_SW9-tMZwtOIRM68bNyS1csWJHMOfvmKN0Scr_m84UUpqnX6SY3dPGEzZNtYtMdDFiNW8&q=Scans+World+Reviews&sa=X&ved=2ahUKEwiBz7SwurSMAxXfRmwGHdw9BmgQ0bkNegQIHxAE&biw=1536&bih=738&dpr=1.25#lrd=0x3a526642b433cbb1:0x3c4faf28d0dc443c,1,,,," target="_blank">
                      <div class="rating d-flex align-items-center">
                        <span class="review-count">4.7</span>
                        <div class="da-star-rating">
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star full-star">★</span>
                          <span class="star half-star"><svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <defs>
                                <linearGradient id="grad">
                                  <stop offset="80%" stop-color="gold" />
                                  <stop offset="80%" stop-color="gray" />
                                </linearGradient>
                              </defs>
                              <path fill="url(#grad)" d="M12 2l3 7h7l-5 5 2 7-7-4-7 4 2-7-5-5h7z" />
                            </svg>
                          </span>
                        </div>
                      </div>
                    </a>
                  </div>

                </div>
              </div>
            </div>
          </div> -->
        </div>
        <div class="slider-pagination"></div>
      </div>
    </div>
  </section>

<style>

  @media screen and (max-width: 767px) {
     h3.box-title{
    text-align: center
  } 
    
  }
</style>
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

  <div class="space" id="about-sec">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-6">
          <div class="img-box8">
            <img src="assets/scan-world/home/why-us.webp" alt="About">
          </div>
        </div>
        <div class="col-xl-6 mt-30 mt-xl-0 text-center text-xl-start">
          <div class="title-area mb-32">
            <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Why Scans World ?</span>
            <h2 class="sec-title">Trusted Diagnostics at Scans World</h2>
            <p class="sec-text">At Scans World, we prioritize accuracy, convenience, and patient care to ensure the best diagnostic experience for you. Here’s why you should choose us:</p>
          </div>
          <div class="mb-35 mt-n1">
            <div class="checklist style2 list-two-column">
              <ul>
                <li><i class="fas fa-shield-check text-theme2"></i> 24/7 Diagnostic Services</li>
                <li><i class="fas fa-shield-check text-theme2"></i> Advanced Lab Facilities</li>
                <li><i class="fas fa-shield-check text-theme2"></i> Ample Car Parking</li>
                <li><i class="fas fa-shield-check text-theme2"></i> Experienced Medical Team</li>
                <li><i class="fas fa-shield-check text-theme2"></i> Complete Health Check-ups</li>
                <li><i class="fas fa-shield-check text-theme2"></i> Eco-Friendly Environment</li>
              </ul>
            </div>
          </div>
          <div>
            <a href="book-appointment" class="th-btn">Book Appointment</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="z-index-common" data-pos-for="#team-sec" data-sec-pos="bottom-half">
    <div class="container">
      <div class="counter-card-wrap text-center">
        <div class="counter-card">
          <h2 class="box-number">
            <img src="assets/scan-world/home/trust.png" alt="">
          </h2>
          <p class="box-text text-white"> <b>15+ Years of Trust</b></p>
        </div>
        <div class="divider"></div>
        <div class="counter-card">
          <h2 class="box-number">
            <img src="assets/scan-world/home/doctor.png" alt="">
          </h2>
          <p class="box-text text-white"><b>Trusted by Doctors & Hospitals</b></p>
        </div>
        <div class="divider"></div>
        <div class="counter-card">
          <h2 class="box-number">
            <img src="assets/scan-world/home/customer.png" alt="">
          </h2>
          <p class="box-text text-white"><b>Over 1 Crore Patients Served</b></p>
        </div>
 <div class="divider"></div>
        <div class="counter-card">
          <h2 class="box-number">
            <img src="assets/scan-world/analytics.png" alt="">
          </h2>
          <p class="box-text text-white"><b>Advanced Reporting Systems</b></p>
        </div>
      </div>
    </div>

<section class="space">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-8">
        <div class="title-area text-center pt-5">
          <span class="sub-title">
            <img src="assets/scan-world/icon.webp" alt="Icon">Our Experts
          </span>
          <h2 class="sec-title">Meet Our Expert Doctors</h2>
        </div>
      </div>
    </div>

    <div class="slider-area">
      <div class="swiper th-slider has-shadow" id="teamSlider3" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":2},"768":{"slidesPerView":2},"992":{"slidesPerView":3},"1200":{"slidesPerView":4}}}'>
        <div class="swiper-wrapper">
          <?php if ($latest_doctors && $latest_doctors->num_rows > 0) { ?>
            <?php while ($row = $latest_doctors->fetch_assoc()) { ?>
              <div class="swiper-slide">
                <div class="th-team team-grid">
                  <div class="box-img">
                    <img src="<?= htmlspecialchars($url_config . '/' . $doctor_image_path . $row['doctor_image']); ?>"
                         alt="<?= htmlspecialchars($row['image_alttag']); ?>"
                         title="<?= htmlspecialchars($row['image_title']); ?>">
                  </div>
                  <div class="box-content">
                    <h3 class="box-title">
                      <a href="#"
                         class="doctor-detail"
                         data-name="<?= htmlspecialchars($row['doctor_name']); ?>"
                         data-studies="<?= htmlspecialchars($row['doctor_studies']); ?>"
                         data-image="<?= htmlspecialchars($url_config . '/' . $doctor_image_path . $row['doctor_image']); ?>"
                         data-content="<?= htmlspecialchars($row['doctor_content']); ?>"
                         data-bs-toggle="modal"
                         data-bs-target="#exampleModal">
                        <?= htmlspecialchars($row['doctor_name']); ?>
                      </a>
                    </h3>
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

      <button data-slider-prev="#teamSlider3" class="slider-arrow slider-prev">
        <i class="far fa-arrow-left"></i>
      </button>
      <button data-slider-next="#teamSlider3" class="slider-arrow slider-next">
        <i class="far fa-arrow-right"></i>
      </button>
    </div>
  </div>
</section>

    <section class="space" id="blog-sec" data-bg-src="assets/img/bg/blog_bg_1.jpg">
      <div class="container">
        <div class="row justify-content-lg-between justify-content-center align-items-center">
          <div class="col-lg">
            <div class="title-area text-center text-lg-start">
              <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Our Blogs</span>
              <h2 class="sec-title">Latest Blogs</h2>
            </div>
          </div>
          <div class="col-lg-auto d-none d-lg-block">
            <div>
              <a href="blog" class="th-btn">View All Blogs</a>
            </div>
          </div>
        </div>
        <div class="slider-area">
          <div class="swiper th-slider has-shadow" id="blogSlider1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"3"}}}'>
            <div class="swiper-wrapper">
              <?php while ($row = mysqli_fetch_assoc($latest_blog)) { 
    // Extract data from each row
    $slug  = $row['slug'];
    $title = htmlspecialchars($row['title']);
    $image = htmlspecialchars($row['image']);
    $alt   = htmlspecialchars($row['image_alt_tag']);
    $imgTitle = htmlspecialchars($row['image_title']);
?>
              <div class="swiper-slide">
                <div class="blog-card">
                  <div class="blog-img">
                    <img src="<?php echo $url_config . '/' . $blog_image_path . $image; ?>" alt="<?php echo $alt; ?>" title="<?php echo $imgTitle; ?>">
                  </div>
                  <div class="blog-content">
                    <div class="blog-meta">
                      <a href="<?php echo $url_config; ?>/blog-details/<?php echo urlencode($slug); ?>">
                        <i class="fal fa-calendar"></i> 15 March, 2024
                      </a>
                    </div>
                    <h3 class="box-title">
                      <a href="<?php echo $url_config; ?>/blog-details/<?php echo urlencode($slug); ?>">
                        <?php echo (strlen($title) > 36) ? substr($title, 0, 37) . '...' : $title; ?>
                      </a>
                    </h3>
                    <a href="<?php echo $url_config; ?>/blog-details/<?php echo urlencode($slug); ?>" class="th-btn btn-sm">Read More</a>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
          <button data-slider-prev="#blogSlider1" class="slider-arrow slider-prev"><i class="far fa-arrow-left"></i></button>
          <button data-slider-next="#blogSlider1" class="slider-arrow slider-next"><i class="far fa-arrow-right"></i></button>
        </div>
      </div>
    </section>

    <section class="space" id="testi-sec">
      <div class="container">
        <div class="title-area text-center">
          <span class="sub-title"><img src="assets/scan-world/icon.webp" alt="shape">Testimonials</span>
          <h2 class="sec-title">What Our Patients Say?</h2>
        </div>
        <div class="swiper th-slider" id="testiSlide1" data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"1"},"992":{"slidesPerView":"2"},"1200":{"slidesPerView":"2"}}}'>
          <div class="swiper-wrapper">
            <?php if (!empty($latest_testimonial)) { ?>
            <?php foreach ($latest_testimonial as $testimonial) { ?>
            <div class="swiper-slide">
              <div class="testi-card bg-smoke">
                <div class="box-review">
                  <i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i><i class="fa-sharp fa-solid fa-star"></i>
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