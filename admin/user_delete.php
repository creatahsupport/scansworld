<?php
include("../includes/config.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
   
      
    $SQL = "UPDATE  admin set del_i=1 WHERE id=$id";
    if (mysqli_query($con, $SQL)) {
        echo "<script>alert('User Deleted successfully.');</script>";
        echo "<script>window.location.href = 'user.php';</script>";
    } else {
        echo "Error updating blog post: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>