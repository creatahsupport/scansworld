<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
   
    $SQL = "UPDATE  `blog` set del_i=1,deleted_by='$user_id' WHERE id=$id";

    if (mysqli_query($con, $SQL)) {
        echo "<script>alert('Blog post Deleted successfully.');</script>";
        echo "<script>window.location.href = 'blog.php';</script>";
    } else {
        echo "Error updating blog post: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>