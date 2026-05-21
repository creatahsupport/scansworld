<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['user_id'];
    $user_name = trim($_POST['user_name']);
    $email = trim($_POST['emailid']);
    $phone = trim($_POST['phone']);
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

    // 1. Check for Duplicate Username or Email
    $check_stmt = $con->prepare("SELECT id FROM admin WHERE (user_name = ? OR emailid = ?) AND id != ?");
    $check_stmt->bind_param("ssi", $user_name, $email, $id);
    $check_stmt->execute();
    $check_stmt->store_result();
    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('User Name or Email already exists!'); window.history.back();</script>";
        $check_stmt->close();
        exit();
    }
    $check_stmt->close();

    // 2. Prepare Update Query
    if (!empty($password)) {
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $con->prepare("UPDATE admin SET user_name = ?, emailid = ?, phone = ?, branch_id = ?, role = ?, dashboard = ?, settings = ?, general = ?, seo_management = ?, reports = ?, update_date = ?, status = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssssiiiiiiisi", $user_name, $email, $phone, $branch_id, $role, $dashboard, $settings, $general, $seo_management, $reports, $update_date, $status, $password_hashed, $id);
    } else {
        $stmt = $con->prepare("UPDATE admin SET user_name = ?, emailid = ?, phone = ?, branch_id = ?, role = ?, dashboard = ?, settings = ?, general = ?, seo_management = ?, reports = ?, update_date = ?, status = ? WHERE id = ?");
        $stmt->bind_param("sssssiiiiiiis", $user_name, $email, $phone, $branch_id, $role, $dashboard, $settings, $general, $seo_management, $reports, $update_date, $status, $id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('User Updated successfully.'); window.location.href = 'user.php';</script>";
    } else {
        echo "<script>alert('Error updating user: " . addslashes($stmt->error) . "'); window.history.back();</script>";
    }

    $stmt->close();
    $con->close();
}
?>
