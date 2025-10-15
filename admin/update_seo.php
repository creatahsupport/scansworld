<?php
include("../includes/config.php"); 

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $seo_id = $_POST['id'];  // Corrected syntax for retrieving 'id' from $_POST

    // Debug line to confirm $seo_id is set correctly
    // print_r($seo_id); die;

    $sql = "SELECT og_image FROM seo_management WHERE id = $seo_id";
    $result = mysqli_query($con, $sql);
    $existingSeo = mysqli_fetch_assoc($result);
    $existingOgImage = $existingSeo['og_image'];

    $page_url = $_POST['page_url'];
    $meta_title = $_POST['meta_title'];
    $meta_description = $_POST['meta_description'];
    $og_alt_tag = $_POST['og_alt_tag'];
    $og_type = $_POST['og_type'];
    $og_place_name = $_POST['og_place_name'];
    $og_country = $_POST['og_country'];
    $og_postal_code = $_POST['og_postal_code'];
    $icbm = $_POST['icbm'];
    $scheme = $_POST['scheme'];
    $og_description = $_POST['og_description'];
    $og_local = $_POST['og_local'];
    $og_title = $_POST['og_title'];
    $og_position = $_POST['og_position'];
    $og_region = $_POST['og_region'];
    $og_latitude = $_POST['og_latitude'];
    $og_langtitude = $_POST['og_langtitude'];
    $keywords = $_POST['keywords'];
    $author = $_POST['author'];
    $user_id = $_POST['user_id'];
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
                $og_image = $newFileName;
            } else {
                echo "<script>alert('Failed to upload the image.');</script>";
                echo "<script>window.location.href = 'edit_seo.php?id=$seo_id';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Invalid file type. Only PNG and WEBP files are allowed.');</script>";
            echo "<script>window.location.href = 'edit_seo.php?id=$seo_id';</script>";
            exit;
        }
    }

    // Update the SEO data in the database
    $sql = "UPDATE seo_management SET
        page_url = '$page_url',
        meta_title = '$meta_title',
        meta_description = '$meta_description',
        og_alt_tag = '$og_alt_tag',
        og_type = '$og_type',
        og_place_name = '$og_place_name',
        og_country = '$og_country',
        og_postal_code = '$og_postal_code',
        icbm = '$icbm',
        scheme = '$scheme',
        og_description = '$og_description',
        og_local = '$og_local',
        og_title = '$og_title',
        og_position = '$og_position',
        og_region = '$og_region',
        og_latitude = '$og_latitude',
        og_langtitude = '$og_langtitude',
        keywords = '$keywords',
        og_image = '$og_image',
        author = '$author',
        user_id = '$user_id',
        updated_date = '$updated_date'
        WHERE id = $seo_id";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Data updated successfully.');</script>";
        echo "<script>window.location.href = 'seo.php';</script>";
    } else {
        echo "<script>alert('Error updating record: " . mysqli_error($con) . "');</script>";
        echo "<script>window.location.href = 'edit_seo.php?id=$seo_id';</script>";
    }

    exit;
} else {
    header("Location: edit_seo.php?id=$seo_id");
    exit;
}
?>
