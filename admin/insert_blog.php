<?php
include("../includes/config.php"); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $image_title = $_POST['image_title'];
    $meta_title = $_POST['meta_title'];
    $image_alt_tag = $_POST['image_alt_tag'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $user_id = $_POST['user_id'];
    $content = $_POST['content'];
    $created_date = date("Y-m-d H:i:s");
    
    $file_name = '';
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_size = $_FILES['image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($file_ext, $allowed_extensions) && $file_size <= 2097152) { 
            
            $upload_dir = '../uploads/blog/';
            $upload_file = $upload_dir . basename($file_name);
            
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($file_tmp, $upload_file)) {
            } else {
                echo "<script>alert('Failed to upload the image.');</script>";
                echo "<script>window.location.href = 'blog.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid file type or file too large. Only JPG, JPEG, PNG, and GIF are allowed, with a maximum size of 2 MB.');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Image upload error.');</script>";
        exit();
    }
    $query = "INSERT INTO blog (title, slug, image, image_title, meta_title, description, content ,created_date,image_alt_tag,user_id,category) 
              VALUES ('$title', '$slug', '$file_name', '$image_title', '$meta_title', '$description', '$content','$created_date','$image_alt_tag','$user_id','$category')";
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Blog post added successfully.');</script>";
        echo "<script>window.location.href = 'blog.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}

mysqli_close($con);
?>
