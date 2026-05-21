<?php 
ob_start();
// session_start() is already called in config.php
checkAdminLogin();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$sql = "SELECT * FROM settings WHERE del_i = 0 ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $settings = mysqli_fetch_assoc($result);
    $favicon = htmlspecialchars($settings['favicon_logo']);
    $sidebar_logo = htmlspecialchars($settings['sidebar_logo']);
    $website_logo = htmlspecialchars($settings['website_logo']);
    $support_mail = htmlspecialchars($settings['support_mail']);
    $support_number = htmlspecialchars($settings['support_number']);
    $footer_text = htmlspecialchars($settings['footer_text']);
} 
$user_name=$_SESSION['user_name'];

// hasPermission() is now defined in config.php using prepared statements
?>
