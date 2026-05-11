<?php
include("../includes/config.php"); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $image_title = mysqli_real_escape_string($con, $_POST['image_title']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $image_alt_tag = mysqli_real_escape_string($con, $_POST['image_alt_tag']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $category = intval($_POST['category']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
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
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            // Unique file name to prevent collision
            $unique_file_name = time() . '_' . basename($file_name);
            $upload_file = $upload_dir . $unique_file_name;
            
            if (move_uploaded_file($file_tmp, $upload_file)) {
                $file_name = $unique_file_name;
            } else {
                echo "<script>alert('Failed to upload the image.'); window.location.href = 'add_blog.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Invalid file type or file too large. Only JPG, JPEG, PNG, and WEBP are allowed (Max 2 MB).'); window.location.href = 'add_blog.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Please upload a valid blog image.'); window.location.href = 'add_blog.php';</script>";
        exit();
    }
    
    $check_query = "SELECT id FROM blog WHERE title = '$title'";
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Blog title already exists!'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO blog (title, slug, image, image_title, meta_title, description, content, created_date, image_alt_tag, user_id, category) 
              VALUES ('$title', '$slug', '$file_name', '$image_title', '$meta_title', '$description', '$content', '$created_date', '$image_alt_tag', '$user_id', '$category')";
              
    if (mysqli_query($con, $query)) {
        echo "<script>alert('Blog post added successfully.'); window.location.href = 'blog.php';</script>";
    } else {
        $err = mysqli_real_escape_string($con, mysqli_error($con));
        echo "<script>alert('Database Error: " . $err . "'); window.location.href = 'add_blog.php';</script>";
    }
} else {
    header("Location: blog.php");
    exit();
}

mysqli_close($con);
?>
