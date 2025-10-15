<?php
include("includes/config.php");
$base_image = "uploads/gallery/";
$limit = 15; 
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$start = ($page - 1) * $limit;
$RECENTSQL = "SELECT * FROM gallery_management WHERE del_i=0 ORDER BY id DESC LIMIT $start, $limit";
$RECENT_RESULT = mysqli_query($con, $RECENTSQL);
$totalPostsSQL = "SELECT COUNT(*) as total FROM gallery_management WHERE del_i=0";
$totalPostsResult = mysqli_query($con, $totalPostsSQL);
$totalPosts = mysqli_fetch_assoc($totalPostsResult)['total'];
$totalPages = ceil($totalPosts / $limit);
$prevPage = ($page > 1) ? $page - 1 : false;
$nextPage = ($page < $totalPages) ? $page + 1 : false;
?>

<?php include("includes/config.php"); ?>
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

    <div class="breadcumb-wrapper " data-bg-src="assets/scan-world/breadcrumb-news.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title text-white">Our Gallery</h1>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Our Gallery</li>
                </ul>
            </div>
        </div>
    </div>


    <div class="space">
        <div class="container">
            <div class="title-area text-center">
                <!-- <span class="sub-title4"><img src="assets/img/theme-img/title_icon.svg" alt="shape">Portfolio cases</span> -->
                <h2 class="sec-title">Our Gallery</h2>
            </div>
            <div class="row gy-4 masonary-active gallery-row2">
            <?php if ($RECENT_RESULT->num_rows > 0) { ?>
    <?php while ($row = $RECENT_RESULT->fetch_assoc()) { ?>
        <div class="col-lg-4 col-md-4 col-sm-6 filter-item col-xl-auto col-md-6">
            <div class="featured-imagebox featured-imagebox-portfolio style2 gallery-card style2">
            <?php if ($row['media_type'] === 'image') { ?>
    <div class="box-img">
        <img class="img-fluid" style="height: 300px; max-width: 100%;" 
             src="<?= $url_config . '/' . $base_image . $row['image'] ?>" 
             alt="<?= htmlspecialchars($row['image_alt']) ?>" 
             title="<?= htmlspecialchars($row['image_title']) ?>">
    </div>
<?php } elseif ($row['media_type'] === 'video') { ?>
    <iframe class="img-fluid" style="height: 300px; max-width: 100%;" 
            src="<?= htmlspecialchars($row['video']) ?>" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen>
    </iframe>
    <div class="gallery-iframe-title-bgcolor">
        <p class="gallery-content"><?= htmlspecialchars($row['video_title']) ?></p>
    </div>
<?php } ?>


                <div class="box-content">
                    <?php if ($row['media_type'] === 'image') { ?>
                        <a href="<?= $url_config . '/' . $base_image . $row['image'] ?>" 
                           class="icon-btn style2 popup-image" 
                           title="<?= htmlspecialchars($row['image_title']) ?>">
                           <i class="fa fa-search-plus" aria-hidden="true"></i>
                        </a>
                    <?php } ?>
                    <h3 class="box-title"><?= htmlspecialchars($row['title']) ?></h3>
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