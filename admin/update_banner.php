<?php
session_start();
include("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']);
    $imageAlt =  $_POST['image_alt'];
    $user_id = $_POST['user_id'];
    $update_date = date("Y-m-d H:i:s"); 
    $imageTitle = $_POST['image_title'];
    $imageFileName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTempName = $_FILES['image']['tmp_name'];
        $imageFileName = basename($_FILES['image']['name']);
        
        $uploadDirectory = '../uploads/banner/';
        $uploadFile = $uploadDirectory . $imageFileName;
        
        if (!move_uploaded_file($imageTempName, $uploadFile)) {
            echo "Error uploading the file.";
            exit;
        }
    }
    if (!$imageFileName) {
        $sql = "SELECT image FROM banner WHERE id = $id";
        $result = mysqli_query($con, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $galleryItem = mysqli_fetch_assoc($result);
            $imageFileName = $galleryItem['image']; 
        } else {
            die("Error: Banner item not found.");
        }
    }

    $sqlUpdate = "UPDATE banner SET image_alt = '$imageAlt', image_title = '$imageTitle', image = '$imageFileName' ,updated_date='$update_date', created_by='$user_id' WHERE id = $id";
    if (mysqli_query($con, $sqlUpdate)) {
        echo "<script>alert('Banner Updated successfully.');</script>";
        echo "<script>window.location.href = 'banner.php';</script>";
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
} else {
    die("Error: Invalid request.");
}
?>
