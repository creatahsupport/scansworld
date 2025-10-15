<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id = $_POST['id'];
    $title = $_POST['title'];
    $slug = $_POST['slug'];
    $image_alt_tag = $_POST['image_alt_tag'];
    $image_title = $_POST['image_title'];
    $meta_title = $_POST['meta_title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $user_id = $_POST['user_id'];
    $update_date=date("Y-m-d H:i:s");
    $sql_fetch = "SELECT image FROM news_events WHERE id = '$id'";
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
        $target_dir = "../uploads/news_events/";
        $target_file = $target_dir . $image;

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            echo "Failed to upload image.";
            exit;
        }
    }

    $sql_update = "UPDATE news_events SET  title = '$title',slug = '$slug', image_alt = '$image_alt_tag', image_title = '$image_title', meta_title = '$meta_title', meta_description = '$description',content = '$content', image = '$image',update_date='$update_date' ,user_id='$user_id' WHERE id = '$id'";

    if (mysqli_query($con, $sql_update)) {
        echo "<script>alert('News and Events Updated successfully.');</script>";
        echo "<script>window.location.href = 'news_events.php';</script>";
    } else {
        echo "Error updating News and Events: " . mysqli_error($con);
    }
    mysqli_close($con);
}
?>
