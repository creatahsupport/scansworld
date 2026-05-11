<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $department = $_POST['department'];
    $user_id = $_POST['user_id'];
    $created_date = date("Y-m-d H:i:s");

    $department_clean = mysqli_real_escape_string($con, $department);
    $check_query = "SELECT id FROM service WHERE service_name = '$department_clean'";
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Service already exists!'); window.history.back();</script>";
        exit();
    }

    $sql = "INSERT INTO service (service_name,created_date,user_id) VALUES ('$department','$created_date','$user_id')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Service added successfully.'); window.location.href = 'service.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
