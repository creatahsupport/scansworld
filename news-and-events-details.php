<?php
include("includes/config.php");
$title = $content = $image = $slug = $description = $image_alt = $image_title = "";
$base_image = "uploads/news_events/";

if (isset($_GET['slug'])) {
    $news_events = mysqli_real_escape_string($con, $_GET["slug"]);
    $news_query = "SELECT * FROM news_events WHERE slug = '$news_events' AND del_i = 0";
    $news_result = mysqli_query($con, $news_query);

    if ($news_row = mysqli_fetch_assoc($news_result)) {
        $title = $news_row['title'];
        $content = $news_row['content'];
        $image = $news_row['image'];
        $slug = $news_row['slug'];
        $description = $news_row['meta_description'];
        $image_alt = $news_row['image_alt'];
        $image_title = $news_row['image_title'];
    } 
}
$latest_news_query = "SELECT * FROM news_events WHERE del_i = 0 ORDER BY id DESC LIMIT 3";
$latest_news = mysqli_query($con, $latest_news_query);
?>
<!doctype html>
<html class="no-js" lang="zxx">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <?php include_once("seo.php");?>
  
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $url_config; ?>/assets/img/favicons/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $url_config; ?>/assets/img/favicons/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $url_config; ?>/assets/img/favicons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $url_config; ?>/assets/img/favicons/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $url_config; ?>/assets/img/favicons/favicon-16x16.png">
  <link rel="manifest" href="<?php echo $url_config; ?>/assets/img/favicons/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?php echo $url_config; ?>/assets/img/favicons/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $url_config; ?>/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo $url_config; ?>/assets/css/fontawesome.min.css">
  <link rel="stylesheet" href="<?php echo $url_config; ?>/assets/css/magnific-popup.min.css">
  <link rel="stylesheet" href="<?php echo $url_config; ?>/assets/css/swiper-bundle.min.css">
  <link rel="stylesheet" href="<?php echo $url_config; ?>/assets/css/jquery.datetimepicker.min.css">
  <link rel="stylesheet" href="<?php echo $url_config; ?>/assets/css/style.css">

</head>

<body>

  <?php include("header.php") ?>

  <div class="breadcumb-wrapper " data-bg-src="<?php echo $url_config; ?>/assets/scan-world/breadcrumb.png">
    <div class="container">
      <div class="breadcumb-content">
        <h1 class="breadcumb-title text-white">News & Events Details</h1>
        <ul class="breadcumb-menu">
          <li><a href="<?php echo $url_config; ?>/" class="text-white">Home</a></li>
          <li>News & Events Details</li>
        </ul>
      </div>
    </div>
  </div>

  <section class="space-top space-extra-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-10 col-lg-10 mx-auto">
                <div class="page-single single-right mb-30">
                    <div class="page-img">
                        <img src="<?php echo $url_config;?>/<?= $base_image ?><?php echo($image); ?>" 
                            alt="<?php echo($image_alt); ?>" 
                            title="<?php echo($image_title); ?>">
                    </div>
                    <div class="page-content">
                        <h3 class="fw-semibold"><?php echo $title; ?></h3>
                        <?php echo $content; ?>
                    </div>
                </div>
                        <div>
                            <a href="<?php echo $url_config; ?>/news-and-events" class="th-btn"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back </a>
                        </div>
            </div>
            
        </div>
    </div>
</section>


  <?php include("footer.php") ?>

  <div class="scroll-top">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
      <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;"></path>
    </svg>
  </div>

  <script src="<?php echo $url_config; ?>/assets/js/vendor/jquery-3.7.1.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/swiper-bundle.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/bootstrap.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/jquery.magnific-popup.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/jquery.counterup.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/jquery.datetimepicker.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/jquery-ui.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/imagesloaded.pkgd.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/isotope.pkgd.min.js"></script>
  <script src="<?php echo $url_config; ?>/assets/js/main.js"></script>
</body>

</html>