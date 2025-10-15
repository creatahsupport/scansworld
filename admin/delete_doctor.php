<?php
include("../includes/config.php"); 

$id = intval($_POST["id"]);
$user_id = intval($_POST["user_id"]);

$query2 = "UPDATE doctors SET del_i=1, deleted_by='$user_id' WHERE id=$id";

$result2 = mysqli_query($con, $query2);

if ($result2) {
    echo "<script>alert('Doctor details Deleted successfully.');</script>";
    echo "<script>window.location.href = 'doctor.php';</script>";
    exit();
} 

mysqli_close($con);
?>
