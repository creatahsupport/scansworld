<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    {
        unset($_SESSION['admin_logged_in']);
        session_unset();
        session_destroy();
    }
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h1>Welcome to Admin Panel</h1>
    <a href="logout.php">Logout</a>
</body>
</html>
