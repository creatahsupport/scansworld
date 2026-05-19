<?php  
http_response_code(404); 
$script_dir = dirname($_SERVER['SCRIPT_NAME'] ?? '/');
$base_path = ($script_dir === '/' || $script_dir === '\\') ? '/' : rtrim($script_dir, '/') . '/';

include("includes/config.php"); ?>

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

<style>
        .section {
            margin: 0;
            padding: 0;
            text-align: center;
            font-family: sans-serif;

        }

        h1,
        a {
            margin: 0;
            padding: 0;
            text-decoration: none;
        }

        .section {
            padding: 4rem 2rem;
        }

        .section .error {
            font-size: 150px;
            color: #0079c0;
            text-shadow:
                1px 1px 1px #ffffff, 2px 2px 1px #0079c0, 3px 3px 1px #0079c0, 4px 4px 1px #0079c0, 5px 5px 1px #0079c0, 6px 6px 1px #ffffff, 7px 7px 1px #ffffff, 8px 8px 1px #ffffff, 25px 25px 8px rgba(0, 0, 0, 0.2);
        }

        .page {
            margin: 2rem 0;
            font-size: 20px;
            font-weight: 600;
            color: #444;
        }

        .back-home {
            display: inline-block;
            border: 2px solid #222;
            color: #222;
            text-transform: uppercase;
            font-weight: 600;
            padding: 0.75rem 1rem 0.6rem;
            transition: all 0.2s linear;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
        }

        .back-home:hover {
            background: #222;
            color: #ddd;
        }
    </style>
 <div class="section">
        <h1 class="error" style=" text-align: center;">404</h1>
        <div class="page" style=" text-align: center;">Ooops!!! The page you are looking for is not found</div>
        <a class="back-home" href="../">Back to home</a>
    </div>


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