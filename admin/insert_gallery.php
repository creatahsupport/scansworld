<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $media_type =$_POST['media_type'];
    $title =$_POST['title'];
    $video_title =$_POST['video_title'];
    $image_alt =  $_POST['image_alt'];
    $image_title = $_POST['image_title'];
    $video_url = $_POST['video']; 
    $user_id = $_POST['user_id']; 
    $created_date = date("Y-m-d H:i:s"); 
    $image_name = null;
    // print_r($title);die;
    if ($media_type === 'image') {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = "../uploads/gallery/";
            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $newFileName = uniqid('gallery_', true) . '.' . $imageFileType;
            $targetFilePath = $targetDir . $newFileName;

            $allowedTypes = ['png', 'webp'];
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $image_name = $newFileName;
                } else {
                    echo "Failed to upload the image.";
                    exit;
                }
            } else {
                echo "Invalid file type. Only PNG and WEBP files are allowed.";
                exit;
            }
        } else {
            echo "No image file was uploaded.";
            exit;
        }
    } elseif ($media_type === 'video') {
        if (empty($video_url)) {
            echo "Video URL is required.";
            exit;
        }
    } else {
        echo "Invalid media type.";
        exit;
    }
    $sql = "INSERT INTO gallery_management (media_type, image_alt, image_title, image, video,created_date,user_id,title,video_title) VALUES ('$media_type', '$image_alt', '$image_title', '$image_name', '$video_url','$created_date','$user_id','$title','$video_title')";
    // print_r($sql);die;
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Gallery  added successfully.');</script>";
        echo "<script>window.location.href = 'gallery.php';</script>";
    } else {
        echo "Error inserting record: " . mysqli_error($con);
    }

} else {
    header("Location: form_page.php");
    exit;
}
?>
