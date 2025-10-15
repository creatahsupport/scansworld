<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['user_id'];
    $user_name = $_POST['user_name'];
    $email = $_POST['emailid'];
    $phone = $_POST['phone'];
    $branch_id = $_POST['branch_id'];
    $role = $_POST['role'];
    $status = $_POST['status'];
    $dashboard = isset($_POST['dashboard']) ? 1 : 0;
    $settings = isset($_POST['settings']) ? 1 : 0;
    $general = isset($_POST['general']) ? 1 : 0;
    $seo_management = isset($_POST['seo_management']) ? 1 : 0;
    $reports = isset($_POST['reports']) ? 1 : 0;
    $update_date = date("Y-m-d H:i:s");

    $password = $_POST['password'];
    $password_encoded = $password ? base64_encode($password) : '';

    $sql = "UPDATE admin SET user_name = '$user_name',emailid = '$email',phone = '$phone',branch_id = '$branch_id',role = '$role',dashboard = '$dashboard',settings = '$settings',general = '$general',seo_management = '$seo_management',reports = '$reports',update_date = '$update_date', status = '$status'";

    if ($password_encoded) {
        $sql .= ", password = '$password_encoded'";
    }
    $sql .= " WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('User Updated successfully.');</script>";
        echo "<script>window.location.href = 'user.php';</script>";
    } else {
        echo "Error updating user: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
