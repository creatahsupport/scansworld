<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   
    $image_type =$_POST['image_type'];
    $image_alt =  $_POST['image_alt'];
    $image_title = $_POST['image_title']; 
    $user_id = $_POST['user_id']; 
    $created_date = date("Y-m-d H:i:s"); 
    $image_name = null;

   
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = "../uploads/banner/";
            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $newFileName = uniqid('banner_', true) . '.' . $imageFileType;
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
    } 
    
    $sql = "INSERT INTO banner (image_type, image_alt, image_title, image, created_date,created_by) VALUES ('$image_type', '$image_alt', '$image_title', '$image_name','$created_date','$user_id')";
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Banner  added successfully.');</script>";
        echo "<script>window.location.href = 'banner.php';</script>";
    } else {
        echo "Error inserting record: " . mysqli_error($con);
    }

?>
