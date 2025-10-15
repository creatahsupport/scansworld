<?php
include("../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $con->real_escape_string(trim($_POST['name']));
    $slug = $con->real_escape_string(trim($_POST['slug']));
    $user_id = $_POST['user_id'];
    $created_date = date("Y-m-d H:i:s");
    $upload_dir = '../uploads/blog/category_images/';
    $uploadOk = 1;

    $check_query = "SELECT * FROM categories WHERE name = '$name'";
    $result = $con->query($check_query);

    if ($result->num_rows > 0) {
        echo "<script>
            alert('Category Name already exists!');
            window.location.href = 'blog_category.php';
        </script>";
        exit();
    }

    if (isset($_FILES['category_image']) && $_FILES['category_image']['error'] == UPLOAD_ERR_OK) {
        $file_name = $_FILES['category_image']['name'];
        $file_tmp = $_FILES['category_image']['tmp_name'];
        $file_size = $_FILES['category_image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
        $allowed_extensions = ['png', 'webp'];
    
        if (in_array($file_ext, $allowed_extensions) && $file_size <= 2097152) { 
          
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
    
            $upload_file = $upload_dir . basename($file_name);
    
            if (move_uploaded_file($file_tmp, $upload_file)) {
                $stored_file_name = basename($file_name);
            } else {
                echo "<script>
                    alert('Failed to upload the image.');
                    window.location.href = 'blog_category.php';
                </script>";
                exit();
            }
        } else {
            echo "<script>
                alert('Invalid file type or file too large. Only PNG and WEBP files are allowed, with a maximum size of 2 MB.');
                window.location.href = 'blog_category.php';
            </script>";
            exit();
        }
    } else {
        $stored_file_name = null;
    }
    
    $insert_query = "INSERT INTO categories (name, slug, category_image, user_id,created_date) 
                     VALUES ('$name', '$slug', '$stored_file_name ', '$user_id','$created_date')";
    if ($con->query($insert_query) === TRUE) {
        echo "<script>
            alert('Category added successfully!');
            window.location.href = 'blog_category.php';
        </script>";
    } else {
        echo "<script>
            alert('Error: " . $con->error . "');
            window.location.href = 'blog_category.php';
        </script>";
    }
}

$con->close();
?>
