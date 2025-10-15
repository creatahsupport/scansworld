<?php
include("includes/config.php");

if (isset($_GET['q'])) {
    $bids = mysqli_real_escape_string($con, $_GET["q"]);
    $base_image = "uploads/blog/";
    $limit = 15; 
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $start = ($page - 1) * $limit;
    
    // Fetch filtered blog posts
    $RECENTSQL = "SELECT * FROM blog WHERE (title LIKE '%$bids%') AND del_i=0 ORDER BY id DESC LIMIT $start, $limit";
    $RECENT_RESULT = mysqli_query($con, $RECENTSQL);
    
    // Get total filtered count for pagination
    $totalPostsSQL = "SELECT COUNT(*) as total FROM blog WHERE (title LIKE '%$bids%') AND del_i=0";
    $totalPostsResult = mysqli_query($con, $totalPostsSQL);
    $totalPostsRow = mysqli_fetch_assoc($totalPostsResult);
    $totalPosts = $totalPostsRow['total'];
    $totalPages = ($totalPosts > 0) ? ceil($totalPosts / $limit) : 1;
} else {
    echo "<h1>Invalid request</h1>";
    exit;
}
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
<?php include 'header.php'; ?>

    <div class="breadcumb-wrapper " data-bg-src="<?php echo $url_config; ?>/assets/scan-world/breadcrumb.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title text-white">Our Blogs</h1>
                <ul class="breadcumb-menu">
                    <li><a href="./" class="text-white">Home</a></li>
                    <li>Blogs</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="space" id="blog-sec" data-bg-src="<?php echo $url_config; ?>/assets/img/bg/blog_bg_1.jpg">
    <div class="container">
        <div class="row">

        <?php if (mysqli_num_rows($RECENT_RESULT) > 0) { ?>
            <?php while ($RECENT_ROW = mysqli_fetch_array($RECENT_RESULT)) { ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="blog-card">
                    <div class="blog-img">
                    <a href="<?php echo $url_config; ?>/blog-details/<?= urlencode(htmlspecialchars($RECENT_ROW['slug'])); ?>">
                                    <img src="<?php echo $url_config . '/' . $base_image . htmlspecialchars($RECENT_ROW['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($RECENT_ROW['image_alt_tag']); ?>" 
                                         title="<?php echo htmlspecialchars($RECENT_ROW['image_title']); ?>">
                                </a>
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                           
                            <a href="<?php echo $url_config; ?>/blog-details/<?= urlencode(htmlspecialchars($RECENT_ROW['slug'])); ?>"><i class="fal fa-calendar"></i><?php 
                                    $raw_date = $RECENT_ROW['created_date'];
                                    echo date("F j, Y", strtotime($raw_date));
                                ?></a>
                        </div>
                        <h3 class="box-title"><a href="<?php echo $url_config; ?>/blog-details/<?= urlencode(htmlspecialchars($RECENT_ROW['slug'])); ?>"> <?php 
                                                $title = htmlspecialchars($RECENT_ROW['title']);
                                                echo (strlen($title) > 50) ? substr($title, 0, 50) . '...' : $title; 
                                            ?></a></h3>
                        <a href="<?php echo $url_config; ?>/blog-details/<?= urlencode(htmlspecialchars($RECENT_ROW['slug'])); ?>" class="th-btn btn-sm">Read More</a>
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

    <div class="th-pagination text-center">
     <ul>
                    <?php if ($page > 1) { ?>
                        <li><a href="?q=<?= urlencode($bids) ?>&page=<?= ($page - 1) ?>"><i class="fas fa-angle-left"></i></a></li>
                    <?php } ?>
                    
                    <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                        <li><a href="?q=<?= urlencode($bids) ?>&page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"> <?= $i ?> </a></li>
                    <?php } ?>
                    
                    <?php if ($page < $totalPages) { ?>
                        <li><a href="?q=<?= urlencode($bids) ?>&page=<?= ($page + 1) ?>"><i class="fas fa-angle-right"></i></a></li>
                    <?php } ?>
                </ul>
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