<?php
include("../includes/config.php"); 

$sql = "SELECT * FROM settings LIMIT 1";
$result = mysqli_query($con, $sql);
$settings = mysqli_fetch_assoc($result);

if (!$settings) {
    echo "<script>
            alert('No settings found.');
            window.location.href = 'settings.php';
          </script>";
    exit;
}

$website_name = $_POST['website_name'];
$footer_text = $_POST['footer_text'];
$support_phone = $_POST['support_phone'];
$support_mail = $_POST['support_mail'];
$design_develop = $_POST['design_develop'];
$user_id = $_POST['user_id'];

function uploadImage($file, $fieldName, $currentPath) {
    $allowedExtensions = ['png', 'webp'];
    $uploadDir = '../uploads/settings/';
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (in_array($fileExt, $allowedExtensions)) {
            $fileName = $fieldName . '_' . time() . '.' . $fileExt;
            $filePath = $uploadDir . $fileName;
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                return $filePath;
            }
        }
    }
    return $currentPath;
}

$imagePath = !empty($_FILES['image']['name']) ? uploadImage($_FILES['image'], 'image', $settings['website_logo']) : $settings['website_logo'];
$sidebarLogoPath = !empty($_FILES['sidebar_logo']['name']) ? uploadImage($_FILES['sidebar_logo'], 'sidebar_logo', $settings['sidebar_logo']) : $settings['sidebar_logo'];
$faviconPath = !empty($_FILES['favicon_logo']['name']) ? uploadImage($_FILES['favicon_logo'], 'favicon_logo', $settings['favicon_logo']) : $settings['favicon_logo'];

$sql = "UPDATE settings SET 
            website_name='$website_name', 
            footer_text='$footer_text', 
            support_number='$support_phone', 
            support_mail='$support_mail', 
            design_develop='$design_develop', 
            website_logo='$imagePath', 
            sidebar_logo='$sidebarLogoPath', 
            updated_by='$user_id', 
            favicon_logo='$faviconPath'";

if (mysqli_query($con, $sql)) {
    echo "<script>
            alert('Settings updated successfully.');
            window.location.href = 'settings.php';
          </script>";
} else {
    echo "<script>
            alert('Error updating settings: " . mysqli_error($con) . "');
            window.location.href = 'settings.php';
          </script>";
}

mysqli_close($con);
?>
