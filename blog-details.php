<?php
include("includes/config.php");

if (!isset($con) || !$con) {
    die("Database connection not established.");
}

if (isset($_GET['bid'])) {
    $bids = mysqli_real_escape_string($con, $_GET["bid"]);
    $BLOGSQL = "SELECT * FROM blog WHERE slug = '$bids' AND del_i = 0";
    $BLOG_RESULT = mysqli_query($con, $BLOGSQL);
    if ($BLOG_ROW = mysqli_fetch_assoc($BLOG_RESULT)) {
        $title = $BLOG_ROW['title'];
        $content = $BLOG_ROW['content']; // CKEditor HTML content
        $image = $BLOG_ROW['image'];
        $slug = $BLOG_ROW['slug'];
        $description = $BLOG_ROW['description'];
        $image_alt_tag = $BLOG_ROW['image_alt_tag'];
        $image_title = $BLOG_ROW['image_title'];
        $created_at = $BLOG_ROW['created_at'] ?? ''; // optional date
    } else {
        echo "<h1>Blog not found</h1>";
        exit;
    }
} else {
    echo "<h1>Invalid request</h1>";
    exit;
}

// Fetch latest blogs (limit 3)
$blog = "SELECT * FROM blog WHERE del_i = 0 ORDER BY id DESC LIMIT 3";
$latest_blog = mysqli_query($con, $blog);

// Fetch blog categories (limit 6)
$category_query = "SELECT id, name,category_image,slug FROM categories WHERE del_i = 0 ORDER BY id DESC LIMIT 6";
$latest_category = mysqli_query($con, $category_query);
?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php include_once("seo.php");?>
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $url_config ; ?>/assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo $url_config ; ?>/assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $url_config ; ?>/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $url_config ; ?>/assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $url_config ; ?>/assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo $url_config ; ?>/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo $url_config ; ?>/assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,100;9..40,200;9..40,300;9..40,400;9..40,500;9..40,600;9..40,700;9..40,800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $url_config ; ?>/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $url_config ; ?>/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo $url_config ; ?>/assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="<?php echo $url_config ; ?>/assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="<?php echo $url_config ; ?>/assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="<?php echo $url_config ; ?>/assets/css/style.css">

</head>

<body>

<?php include("header.php") ?>
  

    <div class="breadcumb-wrapper " data-bg-src="<?php echo $url_config ; ?>/assets/scan-world/breadcrumb-blog.png">
        <div class="container">
            <div class="breadcumb-content">
                <h1 class="breadcumb-title text-white">Blog Details</h1>
                <ul class="breadcumb-menu">
                    <li><a href="<?php echo $url_config ; ?>/" class="text-white">Home</a></li>
                    <li>Blog Details</li>
                </ul>
            </div>
        </div>
    </div>

    <section class="th-blog-wrapper blog-details space-top space-extra-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xxl-8 col-lg-7">
                    <div class="th-blog blog-single">
                        <div class="blog-img">
                        <img src="<?php echo $url_config; ?>/uploads/blog/<?php echo htmlspecialchars($image); ?>"
                                 alt="<?php echo htmlspecialchars($image_alt_tag); ?>"
                                 title="<?php echo htmlspecialchars($image_title); ?>">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                              
                               <?php if (!empty($created_at)): ?>
                                <div class="post-date">
                                    <?php echo date("d", strtotime($created_at)); ?>
                                    <span><?php echo date("M/Y", strtotime($created_at)); ?></span>
                                </div>
                            <?php endif; ?>
                         
                            </div>
                            <h2 class="blog-title"><?php echo htmlspecialchars($title); ?></h2>
                            <p><?php
                            // Convert <oembed> tags to iframe for embedded videos
                            $display_content = preg_replace_callback(
                                '/<oembed\s+url="([^"]+)"><\/oembed>/i',
                                function ($matches) {
                                    $url = htmlspecialchars($matches[1], ENT_QUOTES);
                                    return '<div class="video-container"><iframe width="560" height="315" src="' . $url . '" frameborder="0" allowfullscreen></iframe></div>';
                                },
                                $content
                            );
                            echo $display_content;
                            ?></p>
                          
                        </div>
                    </div>
                
                </div>
                <div class="col-xxl-4 col-lg-5">
                    <aside class="sidebar-area">
                        <div class="widget widget_search  ">
                            <form class="search-form" action="<?php echo $url_config; ?>/blog_search.php" method="GET" onsubmit="return validateSearch()">
                                <input type="text" id="search-input" name="q" onkeyup="fetchSearchSuggestions()" placeholder="Enter Keyword">
                                <button type="submit" value="Search"><i class="far fa-search"></i></button>
                            </form>
                        </div>
                        <div class="widget widget_categories  ">
                            <h3 class="widget_title">Categories</h3>
                            <ul>
                            <?php if (mysqli_num_rows($latest_category) > 0) { ?>
                                <?php while ($category = mysqli_fetch_assoc($latest_category)) { ?>
                                <li>
                                    <a href="<?php echo $url_config; ?>/blog/<?php echo urlencode($category['slug']); ?>"><?php echo htmlspecialchars(substr($category['name'], 0, 20)); ?></a>
                                </li>
                                <?php } ?>
<?php } else { ?>
    <li>No categories available.</li>
<?php } ?>
                            </ul>
                        </div>
                        <div class="widget  ">
                            <h3 class="widget_title">Recent Posts</h3>
                            <div class="recent-post-wrap">
                            <?php if (!empty($latest_blog)) { // Check if posts exist ?>
                                <?php foreach ($latest_blog as $blg) { ?>
                                <div class="recent-post">
                                    <div class="media-img">
                                    <a href="<?php echo $url_config; ?>/blog-details/<?php echo urlencode($blg['slug']); ?>">
                        <img src="<?php echo $url_config; ?>/uploads/blog/<?php echo htmlspecialchars($blg['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($blg['title']); ?>" 
                                 title="<?php echo htmlspecialchars($blg['title']); ?>" width="90px" height="80px">
                    </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="post-title"><a class="text-inherit" href="<?php echo $url_config; ?>/blog-details/<?php echo urlencode($blg['slug']); ?>"><?php echo (strlen($blg['title']) > 37) ? substr($blg['title'], 0, 37) . '...' : $blg['title']; ?></a></h4>
                                        <div class="recent-post-meta">
                                            <a href="<?php echo $url_config; ?>/blog-details/<?php echo urlencode($blg['slug']); ?>"><i class="fal fa-calendar"></i> <?php echo date("d-M-Y", strtotime($blg['created_date'])); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
            <?php } else { ?>
                <p class="text-center">No recent posts available.</p>
            <?php } ?>
                            </div>
                        </div>
                     
                    </aside>
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

    <script src="<?php echo $url_config ; ?>/assets/js/vendor/jquery-3.7.1.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/swiper-bundle.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/bootstrap.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/jquery.counterup.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/jquery.datetimepicker.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/jquery-ui.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/isotope.pkgd.min.js"></script>
    <script src="<?php echo $url_config ; ?>/assets/js/main.js"></script>
</body>

</html>