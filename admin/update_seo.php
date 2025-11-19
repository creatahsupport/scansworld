<?php
include("../includes/config.php"); 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seo_id = intval($_POST['id']);

    // Get existing data
    $sql = "SELECT og_image, twitter_image FROM seo_management WHERE id = $seo_id";
    $result = mysqli_query($con, $sql);
    $existingSeo = mysqli_fetch_assoc($result);
    $existingOgImage = $existingSeo['og_image'];
    $existingTwitterImage = $existingSeo['twitter_image'];

    // Get all form data with null coalescing for empty values
    $page_url = $_POST['page_url'] ?? '';
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_description = $_POST['meta_description'] ?? '';
    $og_alt_tag = $_POST['og_alt_tag'] ?? '';
    $og_type = $_POST['og_type'] ?? '';
    $og_place_name = $_POST['og_place_name'] ?? '';
    $og_country = $_POST['og_country'] ?? '';
    $og_postal_code = $_POST['og_postal_code'] ?? '';
    $icbm = $_POST['icbm'] ?? '';
    $scheme = $_POST['scheme'] ?? '';
    $og_description = $_POST['og_description'] ?? '';
    $og_local = $_POST['og_local'] ?? '';
    $og_title = $_POST['og_title'] ?? '';
    $og_position = $_POST['og_position'] ?? '';
    $og_region = $_POST['og_region'] ?? '';
    $og_latitude = $_POST['og_latitude'] ?? '';
    $og_langtitude = $_POST['og_langtitude'] ?? '';
    $keywords = $_POST['keywords'] ?? '';
    $author = $_POST['author'] ?? '';
    $user_id = $_POST['user_id'] ?? '';
    
    // New fields
    $publisher = $_POST['publisher'] ?? '';
   
    $twitter_title = $_POST['twitter_title'] ?? '';
    $twitter_description = $_POST['twitter_description'] ?? '';
    $twitter_site = $_POST['twitter_site'] ?? '';
    
    $updated_date = date("Y-m-d H:i:s");

    // Handle OG image upload if a new file is provided
    $og_image = $existingOgImage;
    if (isset($_FILES['og_image']) && $_FILES['og_image']['error'] == 0) {
        $targetDir = "../uploads/seo/";
        $imageFileType = strtolower(pathinfo($_FILES['og_image']['name'], PATHINFO_EXTENSION));
        $newFileName = uniqid('og_image_', true) . '.' . $imageFileType;
        $targetFilePath = $targetDir . $newFileName;

        $allowedTypes = ['png', 'webp'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['og_image']['tmp_name'], $targetFilePath)) {
                // Delete old image if exists
                if (!empty($existingOgImage) && file_exists($targetDir . $existingOgImage)) {
                    unlink($targetDir . $existingOgImage);
                }
                $og_image = $newFileName;
            } else {
                echo "<script>alert('Failed to upload the OG image.');</script>";
                echo "<script>window.location.href = 'edit_seo.php?id=$seo_id';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid file type for OG image. Only PNG and WEBP files are allowed.');</script>";
            echo "<script>window.location.href = 'edit_seo.php?id=$seo_id';</script>";
            exit;
        }
    }

    // Handle Twitter image upload if a new file is provided
    $twitter_image = $existingTwitterImage;
    if (isset($_FILES['twitter_image']) && $_FILES['twitter_image']['error'] == 0) {
        $targetDir = "../uploads/seo/";
        $imageFileType = strtolower(pathinfo($_FILES['twitter_image']['name'], PATHINFO_EXTENSION));
        $newFileName = uniqid('twitter_image_', true) . '.' . $imageFileType;
        $targetFilePath = $targetDir . $newFileName;

        $allowedTypes = ['png', 'webp'];
        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['twitter_image']['tmp_name'], $targetFilePath)) {
                // Delete old image if exists
                if (!empty($existingTwitterImage) && file_exists($targetDir . $existingTwitterImage)) {
                    unlink($targetDir . $existingTwitterImage);
                }
                $twitter_image = $newFileName;
            } else {
                echo "<script>alert('Failed to upload the Twitter image.');</script>";
                echo "<script>window.location.href = 'edit_seo.php?id=$seo_id';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid file type for Twitter image. Only PNG and WEBP files are allowed.');</script>";
            echo "<script>window.location.href = 'edit_seo.php?id=$seo_id';</script>";
            exit;
        }
    }

    // Escape all values to prevent SQL injection
    $page_url = mysqli_real_escape_string($con, $page_url);
    $meta_title = mysqli_real_escape_string($con, $meta_title);
    $meta_description = mysqli_real_escape_string($con, $meta_description);
    $og_alt_tag = mysqli_real_escape_string($con, $og_alt_tag);
    $og_type = mysqli_real_escape_string($con, $og_type);
    $og_place_name = mysqli_real_escape_string($con, $og_place_name);
    $og_country = mysqli_real_escape_string($con, $og_country);
    $og_postal_code = mysqli_real_escape_string($con, $og_postal_code);
    $icbm = mysqli_real_escape_string($con, $icbm);
    $scheme = mysqli_real_escape_string($con, $scheme);
    $og_description = mysqli_real_escape_string($con, $og_description);
    $og_local = mysqli_real_escape_string($con, $og_local);
    $og_title = mysqli_real_escape_string($con, $og_title);
    $og_position = mysqli_real_escape_string($con, $og_position);
    $og_region = mysqli_real_escape_string($con, $og_region);
    $og_latitude = mysqli_real_escape_string($con, $og_latitude);
    $og_langtitude = mysqli_real_escape_string($con, $og_langtitude);
    $keywords = mysqli_real_escape_string($con, $keywords);
    $author = mysqli_real_escape_string($con, $author);
    $user_id = mysqli_real_escape_string($con, $user_id);
    $publisher = mysqli_real_escape_string($con, $publisher);
    $twitter_title = mysqli_real_escape_string($con, $twitter_title);
    $twitter_description = mysqli_real_escape_string($con, $twitter_description);
    $twitter_site = mysqli_real_escape_string($con, $twitter_site);

    // Update the SEO data in the database
    $sql = "UPDATE seo_management SET
        page_url = '$page_url',
        meta_title = '$meta_title',
        meta_description = '$meta_description',
        keywords = '$keywords',
        publisher = '$publisher',
        author = '$author',
        og_description = '$og_description',
        og_image = '$og_image',
        og_local = '$og_local',
        og_alt_tag = '$og_alt_tag',
        og_title = '$og_title',
        og_type = '$og_type',
        og_position = '$og_position',
        og_place_name = '$og_place_name',
        og_region = '$og_region',
        og_country = '$og_country',
        og_latitude = '$og_latitude',
        og_postal_code = '$og_postal_code',
        og_langtitude = '$og_langtitude',
        icbm = '$icbm',
        twitter_title = '$twitter_title',
        twitter_description = '$twitter_description',
        twitter_image = '$twitter_image',
        twitter_site = '$twitter_site',
        scheme = '$scheme',
        user_id = '$user_id',
        updated_date = '$updated_date'
        WHERE id = $seo_id";

    if (mysqli_query($con, $sql)) {
        // print_r($sql);die;
        echo "<script>alert('SEO data updated successfully.');</script>";
        echo "<script>window.location.href = 'seo.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        echo "<script>window.location.href = 'edit_seo.php?id=$seo_id';</script>";
    }

    exit;
} else {
    header("Location: seo.php");
    exit;
}
?>