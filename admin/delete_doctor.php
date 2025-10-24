<?php
declare(strict_types=1);
error_reporting(E_ALL);
ini_set('display_errors', '1');

include("../includes/config.php"); 

// Basic guard
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: doctor.php');
  exit;
}

// Inputs
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
// This field in your form is actually a username (string), not a numeric id:
$deleted_by = isset($_POST['user_id']) ? trim($_POST['user_id']) : ''; 

if ($id <= 0 || $deleted_by === '') {
  echo "<script>alert('Invalid request');window.location.href='doctor.php';</script>";
  exit;
}

// Soft-delete: set del_i=1, track who deleted, and update timestamp
$sql = "UPDATE doctors 
        SET del_i = 1, deleted_by = ?, update_date = NOW()
        WHERE id = ? AND del_i = 0";

$stmt = $con->prepare($sql);
if (!$stmt) {
  echo "<script>alert('Database error preparing statement');window.location.href='doctor.php';</script>";
  exit;
}

$stmt->bind_param('si', $deleted_by, $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
  echo "<script>alert('Doctor deleted successfully.');window.location.href='doctor.php';</script>";
} else {
  // Either record not found or already deleted
  echo "<script>alert('Nothing to delete or already deleted.');window.location.href='doctor.php';</script>";
}

$stmt->close();
$con->close();
