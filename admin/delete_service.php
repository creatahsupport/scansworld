<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($con, $_POST['id']);
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    $sql = "UPDATE service SET del_i = 1, deleted_by='$user_id' WHERE id = '$id'";
    
    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Service Deleted successfully.'); window.location.href = 'service.php';</script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
