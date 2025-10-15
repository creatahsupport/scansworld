<?php
session_start();
include("../includes/config.php"); 

// Check if the request method is POST and the ID is valid
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']); // Retrieve ID from the POST request
    $imageAlt = mysqli_real_escape_string($con, $_POST['image_alt']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $video_title = mysqli_real_escape_string($con, $_POST['video_title']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $update_date = date("Y-m-d H:i:s"); 
    $imageTitle = mysqli_real_escape_string($con, $_POST['image_title']);
    $video = mysqli_real_escape_string($con, $_POST['video']);
    $imageFileName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imageTempName = $_FILES['image']['tmp_name'];
        $imageFileName = basename($_FILES['image']['name']);
        
        $uploadDirectory = '../uploads/gallery/';
        $uploadFile = $uploadDirectory . $imageFileName;
        
        if (!move_uploaded_file($imageTempName, $uploadFile)) {
            echo "Error uploading the file.";
            exit;
        }
    }
    if (!$imageFileName) {
        $sql = "SELECT image FROM gallery_management WHERE id = $id";
        $result = mysqli_query($con, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $galleryItem = mysqli_fetch_assoc($result);
            $imageFileName = $galleryItem['image']; 
        } else {
            die("Error: Gallery item not found.");
        }
    }

    $sqlUpdate = "UPDATE gallery_management SET image_alt = '$imageAlt', image_title = '$imageTitle', video = '$video', image = '$imageFileName' ,update_date='$update_date', user_id='$user_id',video_title='$video_title',title='$title' WHERE id = $id";
    if (mysqli_query($con, $sqlUpdate)) {
        echo "<script>alert('Gallery Updated successfully.');</script>";
        echo "<script>window.location.href = 'gallery.php';</script>";
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
} else {
    die("Error: Invalid request.");
}
?>
