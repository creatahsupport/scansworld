<?php  

// require_once("mail/mail.php"); 
require_once("mail/mail.php"); 
// print_r($To_email);die;

if(isset($_POST['submit_flag']))
  {
$b_name = $_POST['name'];
$b_mail = $_POST["email"];
$b_phone = $_POST["phone"];

$be_msg =  $_POST['message'];

    
$subject="New Enquiry - Request Callback ";
$admin_msg =  "<p>Dear Admin,</p>
<p>You have received request call back enquiry. Please check the below details</p>
<p></p>
<p>Name: ".$_POST['name']."</p>
<p>email: ".$_POST['email']."</p>
<p>phone: ".$_POST['phone']."</p>
<p>message: ".$_POST['message']."</p>";

    mailer($subject,$admin_msg,$To_email);


echo "<script>alert('Enquiry submitted  successfully')</script>";
}

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

    <?php include("header.php") ?>

    <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/breadcrumb-contact.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title text-white">Contact Us</h1>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="space">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-4 col-md-6">
                    <div class="location-card">
                        <h3 class="box-title">Aminjikarai</h3>
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
                            <a href="tel:+04435079999" class="info-box_link">044 - 3507 9999</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-mobile"></i>
                            <a href="tel:+919445439999" class="info-box_link"> +91 94454 39999</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-map"></i>
                            <a href="https://maps.app.goo.gl/FjEBDCCANQBi3duh6" target="_blank"
                                class="info-box_link">Get Direction</a>
                        </p>
                    </div>

                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="location-card active">
                        <h3 class="box-title">Nandanam</h3>
                        <p class="footer-info">
                            <i class="far fa-location-dot"></i>
                            No. 127, Basement, Chamiers Road, Nandanam, Chennai – 600 035.
                        </p>
                        <p class="footer-info">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:scansworldonchamiersroad@gmail.com"
                                class="info-box_link">scansworldonchamiersroad@gmail.com</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-phone"></i>
                            <a href="tel:+04440699999" class="info-box_link">044 - 4069 9999</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-mobile"></i>
                            <a href="tel:+919626959999" class="info-box_link">+91 96269 59999</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-map"></i>
                            <a href="https://maps.app.goo.gl/9Jpwa4BzsqywPc9U6" target="_blank"
                                class="info-box_link">Get Direction</a>
                        </p>
                    </div>

                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="location-card ">
                        <h3 class="box-title">Nanganallur</h3>
                        <p class="footer-info">
                            <i class="far fa-location-dot"></i>
                            No. 19, 29th Street, Nanganallur, Chennai – 600 061.
                        </p>
                        <p class="footer-info">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:scansworldonnanganallur@gmail.com"
                                class="info-box_link">scansworldonnanganallur@gmail.com</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-phone"></i>
                            <a href="tel:+04435059999" class="info-box_link">044 - 3505 9999</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-mobile"></i>
                            <a href="tel:+917200048999" class="info-box_link">+91 72000 48999</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-map"></i>
                            <a href="https://maps.app.goo.gl/E8NKHqKTzzv7tfq79" target="_blank"
                                class="info-box_link">Get Direction</a>
                        </p>
                    </div>

                </div>

                <!-- <div class="col-xl-4 col-md-6">
                    <div class="location-card active">
                        <h3 class="box-title">Mylapore</h3>
                        <p class="footer-info">
                            <i class="far fa-location-dot"></i>
                            No. 47, Oliver Road, Mylapore, Chennai – 600004
                        </p>
                        <p class="footer-info">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:scanpointctscans@gmail.com"
                                class="info-box_link">scanpointctscans@gmail.com</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-phone"></i>
                            <a href="tel:+04435059999" class="info-box_link">444 - 3331 000</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-mobile"></i>
                            <a href="tel:+917305884341" class="info-box_link">+91 73058 84341</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-map"></i>
                            <a href="https://maps.app.goo.gl/ywemjafUaHRSCPCJ7" target="_blank"
                                class="info-box_link">Get Direction</a>
                        </p>
                    </div>

                </div> -->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="location-card ">
                        <h3 class="box-title">Nungambakkam</h3>
                        <p class="footer-info">
                            <i class="far fa-location-dot"></i>
                            119, Rama St, Nungambakkam, Chennai - 600034
                        </p>
                        <p class="footer-info">
                            <i class="far fa-envelope"></i>
                            <a href="mailto:scanpointctscans@gmail.com" class="info-box_link">scanpointctscans@gmail.com</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-phone"></i>
                            <a href="tel:+04435059999" class="info-box_link">444 - 3331 000</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-mobile"></i>
                            <a href="tel:+917305884341" class="info-box_link">+91 73058 84341</a>
                        </p>
                        <p class="footer-info">
                            <i class="far fa-map"></i>
                            <a href="https://maps.app.goo.gl/EmbGabwJ87Bqd2o76" target="_blank" class="info-box_link">Get Direction</a>
                        </p>
                    </div>
         
                </div> -->
            </div>
        </div>
    </div>
    <div class="space-bottom">
        <div class="container">
            <form method="post" onsubmit="return validateForm();"
                class="contact-form" data-bg-src="assets/scan-world/contact-us.png">
                <div class="input-wrap">
                    <h2 class="sec-title">Get In Touch!</h2>
                    <div class="row">
                        <div class="form-group col-12">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Your Name"
                                autoComplete='none' oncopy="return false;" onpaste="return false;"
                                oninput="this.value = this.value.replace(/[^a-z. A-Z]/g, '').replace(/(\..*)\./g, '$1');"
                                required>
                            <i class="fal fa-user"></i>
                        </div>
                        <div class="form-group col-12">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address"
                                autoComplete='none' oncopy="return false;" onpaste="return false;" required>
                            <i class="fal fa-envelope"></i>
                        </div>
                        <div class="form-group col-12">
                            <input type="text" class="form-control" name="phone" id="number" placeholder="Phone Number"
                                required autocomplete="off" inputmode="numeric" pattern="[1-9]{1}[0-9]{9}"
                                title="Please enter exactly 10 digits, starting with 1-9" oncopy="return false;"
                                onpaste="return false;" oncut="return false;" oncontextmenu="return false;"
                                onkeypress="return isNumberKey(event)" oninput="validatePhoneNumber(this);">
                            <i class="fal fa-phone"></i>
                        </div>

                        <div class="form-group col-12">
                            <textarea name="message" id="message" cols="30" rows="3" class="form-control"
                                placeholder="Type Appointment Note..." required oncopy="return false;"
                                onpaste="return false;" oncut="return false;" oncontextmenu="return false;"></textarea>
                            <i class="fal fa-pencil"></i>
                        </div>
                        <div class="form-btn col-12">
                            <button class="th-btn btn-fw" type="submit" name="submit_flag">Submit</button>
                        </div>
                    </div>
                    <p class="form-messages mb-0 mt-3"></p>
                </div>

            </form>
        </div>
    </div>

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