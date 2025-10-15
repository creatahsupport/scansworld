<?php
include("../includes/config.php");
session_start();
$user_name = isset($_POST['username']) ? trim(mysqli_real_escape_string($con, $_POST['username'])) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
if (empty($user_name) || empty($password)) {
    echo "<script>alert('Please provide both username and password.'); window.location.href = 'index.php';</script>";
    exit();
}
$encoded_password = base64_encode($password);
$sql = "SELECT * FROM admin WHERE user_name = '$user_name' AND password = '$encoded_password' AND status = 1 AND del_i = 0";

$result = $con->query($sql);

if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc(); // Fetch user data properly

    $_SESSION['user_name'] = $user_name;
    $_SESSION['role'] = $row['role']; // Corrected role assignment
    $_SESSION['last_activity'] = time(); // Track last activity for session timeout

    header("Location: dashboard.php");
    exit();
} else {
    echo "<script>alert('Access Denied: Invalid username or password.'); window.location.href = 'index.php';</script>";
    exit();
}

$con->close();
?>
