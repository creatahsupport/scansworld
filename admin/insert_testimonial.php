<?php
include("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $title = $_POST['title'];
    // $review =$_POST['review'];
    $content = $_POST['content'];
    $user_id = $_POST['user_id'];
    $created_date = date("Y-m-d H:i:s"); 

    $title_clean = mysqli_real_escape_string($con, $title);
    $check_query = "SELECT id FROM testimonial WHERE title = '$title_clean'";
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Testimonial title already exists!'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO testimonial (title, content,created_date,user_id) VALUES ('$title', '$content','$created_date','$user_id')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Testimonial  added successfully.');</script>";
        echo "<script>window.location.href = 'testimonial.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    die("Error: Invalid request.");
}
?>
