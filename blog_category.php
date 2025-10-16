<?php
include("includes/config.php");

if (isset($_GET['bids'])) {
    $bids = mysqli_real_escape_string($con, $_GET["bids"]);

    // 1. Get category details
    $sqlCategory = "SELECT id, name, slug, category_image FROM categories WHERE slug = ? AND del_i = 0";
    $stmtCategory = mysqli_prepare($con, $sqlCategory);
    mysqli_stmt_bind_param($stmtCategory, "s", $bids);
    mysqli_stmt_execute($stmtCategory);
    $resCategory = mysqli_stmt_get_result($stmtCategory);

    if ($BLOG_ROW = mysqli_fetch_assoc($resCategory)) {
        $category_id = $BLOG_ROW['id'];
        $category_name = $BLOG_ROW['name'];
        $category_image = $BLOG_ROW['category_image'];
    } else {
        echo "<h1>Category not found!</h1>";
        exit;
    }
    mysqli_stmt_close($stmtCategory);

    // 2. Pagination setup
    $base_image = "uploads/blog/";
    $limit = 9;
    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $start = ($page - 1) * $limit;

    // 3. Fetch blogs under this category
    $sqlPosts = "SELECT * FROM blog WHERE category = ? AND del_i = 0 ORDER BY id DESC LIMIT ?, ?";
    $stmtPosts = mysqli_prepare($con, $sqlPosts);
    mysqli_stmt_bind_param($stmtPosts, "iii", $category_id, $start, $limit);
    mysqli_stmt_execute($stmtPosts);
    $RECENT_RESULT = mysqli_stmt_get_result($stmtPosts);
    mysqli_stmt_close($stmtPosts);

    // 4. Count total blogs for pagination
    $sqlCount = "SELECT COUNT(*) AS total FROM blog WHERE category = ? AND del_i = 0";
    $stmtCount = mysqli_prepare($con, $sqlCount);
    mysqli_stmt_bind_param($stmtCount, "i", $category_id);
    mysqli_stmt_execute($stmtCount);
    $resCount = mysqli_stmt_get_result($stmtCount);
    $totalPosts = mysqli_fetch_assoc($resCount)['total'] ?? 0;
    mysqli_stmt_close($stmtCount);

    $totalPages = max(1, ceil($totalPosts / $limit));
    $prevPage = ($page > 1) ? $page - 1 : false;
    $nextPage = ($page < $totalPages) ? $page + 1 : false;

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
   <title> Scans World | <?= htmlspecialchars($category_name) ?> </title>
    
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

<div class="breadcumb-wrapper" data-bg-src="assets/scan-world/breadcrumb-blog.png">
  <div class="container">
    <div class="breadcumb-content">
      <h1 class="breadcumb-title text-white"><?= htmlspecialchars($category_name) ?></h1>
      <ul class="breadcumb-menu">
        <li><a href="./" class="text-white">Home</a></li>
        <li><?= htmlspecialchars($category_name) ?></li>
      </ul>
    </div>
  </div>
</div>


<section class="space" id="blog-sec">
  <div class="container">
    <div class="row">
      <?php if ($RECENT_RESULT && mysqli_num_rows($RECENT_RESULT) > 0): ?>
        <?php while ($RECENT_ROW = mysqli_fetch_assoc($RECENT_RESULT)): ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="blog-card">
              <div class="blog-img">
                <?php 
                $imageFile = !empty($RECENT_ROW['image']) ? $RECENT_ROW['image'] : $category_image;
                $imgPath = $url_config . '/' . $base_image . htmlspecialchars($imageFile);
                $altTag = htmlspecialchars($RECENT_ROW['image_alt_tag'] ?? $category_name);
                $titleTag = htmlspecialchars($RECENT_ROW['image_title'] ?? $RECENT_ROW['title']);
                ?>
                <img src="<?= $imgPath ?>" alt="<?= $altTag ?>" title="<?= $titleTag ?>" loading="lazy">
              </div>

              <div class="blog-content">
                <div class="blog-meta">
                  <span><i class="fal fa-calendar"></i>
                    <?= !empty($RECENT_ROW['created_date']) ? date('d M, Y', strtotime($RECENT_ROW['created_date'])) : 'Date not available'; ?>
                  </span>
                </div>
                <h3 class="box-title">
                  <a href="<?= $url_config; ?>/blog-details/<?= urlencode($RECENT_ROW['slug']); ?>">
                    <?= htmlspecialchars(mb_strimwidth($RECENT_ROW['title'], 0, 60, '...')); ?>
                  </a>
                </h3>
                <a href="<?= $url_config; ?>/blog-details/<?= urlencode($RECENT_ROW['slug']); ?>" class="th-btn btn-sm">Read More</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12 text-center"><p>No blogs found in this category.</p></div>
      <?php endif; ?>
    </div>

    <?php if ($totalPages > 1): ?>
      <div class="th-pagination text-center">
        <ul>
          <?php if ($prevPage): ?>
            <li><a href="?bids=<?= urlencode($bids) ?>&page=<?= $prevPage ?>"><i class="fas fa-angle-left"></i></a></li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li><a href="?bids=<?= urlencode($bids) ?>&page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a></li>
          <?php endfor; ?>

          <?php if ($nextPage): ?>
            <li><a href="?bids=<?= urlencode($bids) ?>&page=<?= $nextPage ?>"><i class="fas fa-angle-right"></i></a></li>
          <?php endif; ?>
        </ul>
      </div>
    <?php endif; ?>
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