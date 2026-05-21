<?php
include("../includes/config.php");
// session_start(); // Redundant, already in config.php

// Security Hardening: Session regeneration for fresh login attempt
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}

$user_name = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
// Turnstile is currently disabled in index.php by user, so we skip validation if not present
// $turnstile_response = isset($_POST['cf-turnstile-response']) ? $_POST['cf-turnstile-response'] : '';

if (empty($user_name) || empty($password)) {
    echo "<script>alert('Please provide both username and password.'); window.location.href = 'index.php';</script>";
    exit();
}

// 1. Fetch User with Prepared Statement
$stmt = $con->prepare("SELECT id, user_name, password, status, role, login_attempts, lockout_until, two_factor_enabled, two_factor_secret FROM admin WHERE user_name = ? AND del_i = 0");
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // 2. Check Lockout Status
    if ($row['lockout_until'] && strtotime($row['lockout_until']) > time()) {
        $remaining = ceil((strtotime($row['lockout_until']) - time()) / 60);
        echo "<script>alert('Account locked due to multiple failed attempts. Please try again in $remaining minutes.'); window.location.href = 'index.php';</script>";
        exit();
    }

    // 3. Verify Password
    if (password_verify($password, $row['password'])) {
        if ($row['status'] != 1) {
            echo "<script>alert('Account is disabled. Please contact administrator.'); window.location.href = 'index.php';</script>";
            exit();
        }

        // Reset login attempts on success
        $reset_stmt = $con->prepare("UPDATE admin SET login_attempts = 0, lockout_until = NULL WHERE id = ?");
        $reset_stmt->bind_param("i", $row['id']);
        $reset_stmt->execute();

        // Handle Mandatory Two-Factor Authentication (2FA)
        // Every user must go through verify_2fa.php. Setup happens there if not already enabled.
        $_SESSION['temp_user_id'] = $row['id'];
        $_SESSION['temp_user_name'] = $row['user_name'];
        $_SESSION['temp_role'] = $row['role'];
        
        // Explicitly ensure admin_id is NOT set yet
        unset($_SESSION['admin_id']);
        
        header("Location: verify_2fa.php");
        exit();
    } else {
        // 6. Handle Failed Attempt
        $attempts = $row['login_attempts'] + 1;
        $lockout_until = NULL;

        if ($attempts >= 5) {
            $lockout_until = date('Y-m-d H:i:s', strtotime('+15 minutes'));
            echo "<script>alert('Invalid password. Account locked for 15 minutes.'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Invalid username or password.'); window.location.href = 'index.php';</script>";
        }

        $fail_stmt = $con->prepare("UPDATE admin SET login_attempts = ?, lockout_until = ? WHERE id = ?");
        $fail_stmt->bind_param("isi", $attempts, $lockout_until, $row['id']);
        $fail_stmt->execute();
        exit();
    }
} else {
    echo "<script>alert('Access Denied: Invalid username or password.'); window.location.href = 'index.php';</script>";
    exit();
}

$con->close();
?>