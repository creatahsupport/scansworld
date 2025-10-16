<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize all inputs
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
    $image_alt_tag = mysqli_real_escape_string($con, $_POST['image_alt_tag']);
    $image_title = mysqli_real_escape_string($con, $_POST['image_title']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $category = mysqli_real_escape_string($con, $_POST['category']);

    // Fetch current image
    $sql_fetch = "SELECT image FROM blog WHERE id = '$id'";
    $result = mysqli_query($con, $sql_fetch);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image = $row['image'];
    } else {
        echo "Error: Blog post not found.";
        exit;
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = basename($_FILES['image']['name']);
        $target_dir = "../uploads/blog/";
        $target_file = $target_dir . $image;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "Failed to upload image.";
            exit;
        }
    }

    // ✅ Use properly escaped values
    $sql_update = "
        UPDATE blog SET 
            title = '$title',
            slug = '$slug',
            image_alt_tag = '$image_alt_tag',
            image_title = '$image_title',
            meta_title = '$meta_title',
            description = '$description',
            content = '$content',
            image = '$image',
            user_id = '$user_id',
            category = '$category'
        WHERE id = '$id'
    ";

    if (mysqli_query($con, $sql_update)) {
        echo "<script>alert('Blog post updated successfully.');</script>";
        echo "<script>window.location.href = 'blog.php';</script>";
    } else {
        echo "Error updating blog post: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
