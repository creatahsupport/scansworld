<?php
include("../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['department_id'];
    $department = $_POST['department'];
    $user_id = $_POST['user_id'];
    $update_date = date("Y-m-d H:i:s");

    $department_clean = mysqli_real_escape_string($con, $department);
    $check_query = "SELECT id FROM service WHERE service_name = '$department_clean' AND id != '$id'";
    $check_result = mysqli_query($con, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Service already exists!'); window.history.back();</script>";
        exit();
    }

    $sql = "UPDATE service SET service_name = '$department', update_date='$update_date' ,user_id='$user_id' WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Service updated successfully.'); window.location.href = 'service.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>