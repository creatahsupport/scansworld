<?php
include("../includes/config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $user_name = mysqli_real_escape_string($con, trim($_POST['user_name']));
    $emailid = mysqli_real_escape_string($con, trim($_POST['emailid']));
    $phone = mysqli_real_escape_string($con, trim($_POST['phone']));
    $role = mysqli_real_escape_string($con, trim($_POST['role']));
    $status = mysqli_real_escape_string($con, trim($_POST['status']));

    // Permissions
    $dashboard = isset($_POST['dashboard']) ? 1 : 0;
    $settings = isset($_POST['settings']) ? 1 : 0;
    $general = isset($_POST['general']) ? 1 : 0;
    $seo_management = isset($_POST['seo_management']) ? 1 : 0;
    $reports = isset($_POST['reports']) ? 1 : 0;
    
    $created_date = date("Y-m-d H:i:s");

    // Hash password securely
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $check_stmt = $con->prepare("SELECT id FROM admin WHERE user_name = ? OR emailid = ?");
    $check_stmt->bind_param("ss", $user_name, $emailid);
    $check_stmt->execute();
    $check_stmt->store_result();
    if ($check_stmt->num_rows > 0) {
        echo "<script>alert('User Name or Email already exists!'); window.history.back();</script>";
        $check_stmt->close();
        exit();
    }
    $check_stmt->close();

    // Prepare statement
    $stmt = $con->prepare("INSERT INTO admin (user_name, emailid, phone, password, role, status, dashboard, settings, general, seo_management, reports, created_date)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssiiiiiis", $user_name, $emailid, $phone, $password, $role, $status, $dashboard, $settings, $general, $seo_management, $reports, $created_date);

    if ($stmt->execute()) {
        echo "<script>alert('User added successfully.'); window.location.href='user.php';</script>";
    } else {
        echo "<script>alert('Error adding user: " . addslashes($stmt->error) . "');</script>";
    }

    $stmt->close();
    $con->close();
}
?>
