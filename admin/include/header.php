<?php 
ob_start();
session_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}
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


function hasPermission($username, $permission) {
    global $con;
    $sql1 = "SELECT * FROM admin WHERE del_i = 0 and user_name='$username' ORDER BY id DESC LIMIT 1";

$result = mysqli_query($con, $sql1);
if ($result && mysqli_num_rows($result) > 0) {
    $session = mysqli_fetch_assoc($result);
    $id = htmlspecialchars($session['id']);
    // print_r($id);die;
} 
    $sql = "SELECT * FROM admin WHERE id = $id AND $permission = 1";
    $result = mysqli_query($con, $sql);
    return mysqli_num_rows($result) === 1;
}
?>

