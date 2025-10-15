<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $user_id = $_POST['user_id'];
    $slug = $_POST['slug'];
    $image_alt_tag = $_POST['image_alt_tag'];
    $image_title = $_POST['image_title'];
    $meta_title = $_POST['meta_title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $sql_fetch = "SELECT image FROM blog WHERE id = '$id'";
    $result = mysqli_query($con, $sql_fetch);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
    } else {
        echo "Error: Blog post not found.";
        exit;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = basename($_FILES['image']['name']);
        $target_dir = "../uploads/blog/";
        $target_file = $target_dir . $image;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "Failed to upload image.";
            exit;
        }
    }

    $sql_update = "UPDATE blog SET title = '$title', slug = '$slug',image_alt_tag = '$image_alt_tag',image_title = '$image_title',meta_title = '$meta_title',description = '$description',content = '$content',image = '$image',user_id='$user_id',category='$category' WHERE id = '$id'";

    if (mysqli_query($con, $sql_update)) {
        echo "<script>alert('Blog post Updated successfully.');</script>";
        echo "<script>window.location.href = 'blog.php';</script>";
    } else {
        echo "Error updating blog post: " . mysqli_error($con);
    }
    mysqli_close($con);
}
?>
