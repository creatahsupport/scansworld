<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department = $_POST['department'];
    $user_id = $_POST['user_id'];
    $created_date = date("Y-m-d H:i:s");
    $sql = "INSERT INTO service (service_name,created_date,user_id) VALUES ('$department','$created_date','$user_id')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Service added successfully.'); window.location.href = 'service.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
