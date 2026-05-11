<?php
session_start();
include("../includes/config.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    // $review = $_POST['review'];
    $content = $_POST['content'];
    $user_id = $_POST['user_id'];
    $update_date = date("Y-m-d H:i:s");

    $title_clean = mysqli_real_escape_string($con, $title);
    $check_query = "SELECT id FROM testimonial WHERE title = '$title_clean' AND id != $id";
    // print_r($check_query);
    // die;
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Testimonial title already exists!'); window.history.back();</script>";
        exit();
    }

    $sqlUpdate = "UPDATE testimonial SET title = '$title', content = '$content' ,update_date='$update_date',user_id='$user_id' WHERE id = $id";
    if (mysqli_query($con, $sqlUpdate)) {
        echo "<script>alert('Testimonial  Updated successfully.');</script>";
        echo "<script>window.location.href = 'testimonial.php';</script>";
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
} else {
    die("Error: Invalid request.");
}
?>