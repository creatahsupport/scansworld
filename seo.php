<?php 
include("includes/config.php");

$request_uri = $_SERVER['REQUEST_URI'];

// Extract the last segment of the URL
$last_segment = basename(parse_url($request_uri, PHP_URL_PATH));

// Check if $last_segment is empty
if (empty($last_segment)) {
    $last_segment = $request_uri; // Use the entire request URI as fallback
}

// Prepare the SQL query
$sql = "SELECT * FROM seo_management WHERE page_url='$last_segment'";
// print_r($sql);die;
$result = $con->query($sql);
 foreach ($result as $row) {
$meta_title=$row["meta_title"];
$meta_description=$row["meta_description"];
$keywords=$row["keywords"];
$og_title=$row["og_title"];
$og_description=$row["og_description"];
$og_image=$row["og_image"];
$og_local=$row["og_local"];
$og_type=$row["og_type"];
$og_alt_tag=$row["og_alt_tag"];
$og_position=$row["og_position"];
$og_place_name=$row["og_place_name"];
$og_region=$row["og_region"];
$og_country=$row["og_country"];
$og_latitude=$row["og_latitude"];
$og_langtitude=$row["og_langtitude"];
$og_postal_code=$row["og_postal_code"];
$icbm=$row["icbm"];
$author=$row["author"];
$schema=$row["scheme"];
 }
?>
<title>Scans World | <?= !empty($meta_title) ? $meta_title : '' ?></title>
<?php if (!empty($meta_description)): ?>
<meta name="description" content="<?= $meta_description ?>">
<?php endif; ?>
<?php if (!empty($keywords)): ?>
<meta name="keywords" content="<?= $keywords ?>">
<?php endif; ?>
<?php if (!empty($og_title)): ?>
<meta property="og:title" content="<?= $og_title ?>">
<?php endif; ?>
<?php if (!empty($og_description)): ?>
<meta property="og:description" content="<?= $og_description ?>">
<?php endif; ?>
<?php if (!empty($og_image)): ?>
<meta property="og:image" content="<?php echo $url_config; ?>/uploads/seo/<?= $og_image ?>">
<?php endif; ?>
<?php if (!empty($og_local)): ?>
<meta property="og:locale" content="<?= $og_local ?>">
<?php endif; ?>
<?php if (!empty($og_type)): ?>
<meta property="og:type" content="<?= $og_type ?>">
<?php endif; ?>
<?php if (!empty($og_alt_tag)): ?>
<meta property="og:image:alt" content="<?= $og_alt_tag ?>">
<?php endif; ?>
<?php if (!empty($og_position)): ?>
<meta name="geo.position" content="<?= $og_position ?>">
<?php endif; ?>
<?php if (!empty($og_place_name)): ?>
<meta name="geo.placename" content="<?= $og_place_name ?>">
<?php endif; ?>
<?php if (!empty($og_region)): ?>
<meta name="geo.region" content="<?= $og_region ?>">
<?php endif; ?>
<?php if (!empty($og_country)): ?>
<meta name="geo.country" content="<?= $og_country ?>">
<?php endif; ?>
<?php if (!empty($og_latitude)): ?>
<meta name="geo.latitude" content="<?= $og_latitude ?>">
<?php endif; ?>
<?php if (!empty($og_langtitude)): ?>
<meta name="geo.longitude" content="<?= $og_langtitude ?>">
<?php endif; ?>
<?php if (!empty($og_postal_code)): ?>
<meta name="geo.postalcode" content="<?= $og_postal_code ?>">
<?php endif; ?>
<?php if (!empty($icbm)): ?>
<meta name="ICBM" content="<?= $icbm ?>">
<?php endif; ?>
<?php if (!empty($author)): ?>
<meta name="author" content="<?= $author ?>">
<?php endif; ?>
<?php if (isset($schema) && !empty($schema)): ?>
<script type="application/ld+json">
<?= $schema ?>
</script>
<?php endif; ?>

<?php
$current_url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$live_domain = "scansworldonchamiersroad.com";

if (strpos($current_url, $live_domain) !== false) {
 // Live site - allow indexing
 echo '<meta name="robots" content="INDEX,FOLLOW">';
} else {
 // Development site - block indexing
 echo '<meta name="robots" content="NOINDEX,NOFOLLOW">';
}
?>
