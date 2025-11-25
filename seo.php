<?php 
include("includes/config.php");
$request_uri = $_SERVER['REQUEST_URI'];
$last_segment = basename(parse_url($request_uri, PHP_URL_PATH));
if (empty($last_segment)) {
    $last_segment = $request_uri;
}
$sql = "SELECT * FROM seo_management WHERE page_url='$last_segment'";
$result = $con->query($sql);
$meta_title = $meta_description = $keywords = $og_title = $og_description = $og_image = $og_local = '';
$og_type = $og_alt_tag = $og_position = $og_place_name = $og_region = $og_country = $og_latitude = '';
$og_langtitude = $og_postal_code = $icbm = $author = $schema =  $publisher = '';
$article_modified_time =  $twitter_title = $twitter_description = $twitter_image = $twitter_site = '';

foreach ($result as $row) {
    $meta_title = $row["meta_title"] ?? '';
    $meta_description = $row["meta_description"] ?? '';
    $keywords = $row["keywords"] ?? '';
    $og_title = $row["og_title"] ?? '';
    $og_description = $row["og_description"] ?? '';
    $og_image = $row["og_image"] ?? '';
    $og_local = $row["og_local"] ?? '';
    $og_type = $row["og_type"] ?? '';
    $og_alt_tag = $row["og_alt_tag"] ?? '';
    $og_position = $row["og_position"] ?? '';
    $og_place_name = $row["og_place_name"] ?? '';
    $og_region = $row["og_region"] ?? '';
    $og_country = $row["og_country"] ?? '';
    $og_latitude = $row["og_latitude"] ?? '';
    $og_langtitude = $row["og_langtitude"] ?? '';
    $og_postal_code = $row["og_postal_code"] ?? '';
    $icbm = $row["icbm"] ?? '';
    $author = $row["author"] ?? '';
    $schema = $row["scheme"] ?? '';
    
    // New fields
    $publisher = $row["publisher"] ?? '';
    $article_modified_time = $row["created_at"] ?? '';
   
    $twitter_title = $row["twitter_title"] ?? '';
    $twitter_description = $row["twitter_description"] ?? '';
    $twitter_image = $row["twitter_image"] ?? '';
    $twitter_site = $row["twitter_site"] ?? '';
}
?>
<title>Scans World | <?= !empty($meta_title) ? htmlspecialchars($meta_title) : '' ?></title>
<?php if (!empty($meta_description)): ?>
<meta name="description" content="<?= htmlspecialchars($meta_description) ?>">
<?php endif; ?>
<?php if (!empty($keywords)): ?>
<meta name="keywords" content="<?= htmlspecialchars($keywords) ?>">
<?php endif; ?>
<?php if (!empty($canonical)): ?>
<?php $current_url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<link rel="canonical" href="<?php echo htmlspecialchars($current_url); ?>">
<meta property="og:url" content="<?php echo htmlspecialchars($current_url); ?>">
<?php endif; ?>
<?php if (!empty($publisher)): ?>
<meta name="publisher" content="<?= htmlspecialchars($publisher) ?>">
<?php endif; ?>
<?php if (!empty($article_modified_time)): ?>
<meta property="article:modified_time" content="<?= htmlspecialchars($article_modified_time) ?>">
<?php endif; ?>
<?php if (!empty($author)): ?>
<meta name="author" content="<?= htmlspecialchars($author) ?>">
<?php endif; ?>
<meta name="revisit-after" content="7 days">
<meta name="google-site-verification" content="" />
<meta name="googlebot" content="index, follow">
<meta name="robots" content="index, follow">
<?php if (!empty($robots)): ?>
<meta name="robots" content="<?= htmlspecialchars($robots) ?>">
<?php endif; ?>
<?php if (!empty($og_title)): ?>
<meta property="og:title" content="<?= htmlspecialchars($og_title) ?>">
<?php endif; ?>
<?php if (!empty($og_description)): ?>
<meta property="og:description" content="<?= htmlspecialchars($og_description) ?>">
<?php endif; ?>
<?php if (!empty($og_image)): ?>
<meta property="og:image" content="<?php echo $url_config; ?>/uploads/seo/<?= htmlspecialchars($og_image) ?>">
<?php endif; ?>
<?php if (!empty($og_local)): ?>
<meta property="og:locale" content="<?= htmlspecialchars($og_local) ?>">
<?php endif; ?>
<?php if (!empty($og_type)): ?>
<meta property="og:type" content="<?= htmlspecialchars($og_type) ?>">
<?php endif; ?>
<?php if (!empty($og_alt_tag)): ?>
<meta property="og:image:alt" content="<?= htmlspecialchars($og_alt_tag) ?>">
<?php endif; ?>
<?php if (!empty($current_url)): ?>
<meta property="og:url" content="<?= htmlspecialchars($current_url) ?>">
<?php endif; ?>
<?php if (!empty($og_position)): ?>
<meta name="geo.position" content="<?= htmlspecialchars($og_position) ?>">
<?php endif; ?>
<?php if (!empty($og_place_name)): ?>
<meta name="geo.placename" content="<?= htmlspecialchars($og_place_name) ?>">
<?php endif; ?>
<?php if (!empty($og_region)): ?>
<meta name="geo.region" content="<?= htmlspecialchars($og_region) ?>">
<?php endif; ?>
<?php if (!empty($og_country)): ?>
<meta name="geo.country" content="<?= htmlspecialchars($og_country) ?>">
<?php endif; ?>
<?php if (!empty($og_latitude)): ?>
<meta name="geo.latitude" content="<?= htmlspecialchars($og_latitude) ?>">
<?php endif; ?>
<?php if (!empty($og_langtitude)): ?>
<meta name="geo.longitude" content="<?= htmlspecialchars($og_langtitude) ?>">
<?php endif; ?>
<?php if (!empty($og_postal_code)): ?>
<meta name="geo.postalcode" content="<?= htmlspecialchars($og_postal_code) ?>">
<?php endif; ?>
<?php if (!empty($icbm)): ?>
<meta name="ICBM" content="<?= htmlspecialchars($icbm) ?>">
<?php endif; ?>
<?php if (!empty($twitter_title)): ?>
<meta name="twitter:title" content="<?= htmlspecialchars($twitter_title) ?>">
<?php endif; ?>
<?php if (!empty($twitter_description)): ?>
<meta name="twitter:description" content="<?= htmlspecialchars($twitter_description) ?>">
<?php endif; ?>
<?php if (!empty($twitter_image)): ?>
<meta name="twitter:image" content="<?php echo $url_config; ?>/uploads/seo/<?= htmlspecialchars($twitter_image) ?>">
<?php endif; ?>
<?php if (!empty($twitter_site)): ?>
<meta name="twitter:site" content="<?= htmlspecialchars($twitter_site) ?>">
<?php endif; ?>
<?php if (!empty($og_image) && empty($twitter_image)): ?>
<meta name="twitter:image" content="<?php echo $url_config; ?>/uploads/seo/<?= htmlspecialchars($og_image) ?>">
<?php endif; ?>
<meta name="twitter:card" content="summary_large_image">
<?php if (!empty($publisher)): ?>
<link rel="publisher" href="<?= htmlspecialchars($publisher) ?>">
<?php endif; ?>
<?php if (!empty($schema)): ?>
<script type="application/ld+json">
<?= $schema ?>
</script>
<?php endif; ?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CBVPKKHYKX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CBVPKKHYKX');
</script>