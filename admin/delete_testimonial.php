<?php
include("../includes/config.php"); 



$id = $_POST['id'];
$user_id = $_POST['user_id'];

$sql = "UPDATE testimonial SET   del_i=1,deleted_by='$user_id' where id=$id";

if (mysqli_query($con, $sql)) {
    echo "<script>
            alert('Testimonial Deleted successfully.');
            window.location.href = 'testimonial.php';
          </script>";
} else {
    echo "<script>
            alert('Error updating Testimonial: " . mysqli_error($con) . "');
            window.location.href = 'testimonial.php';
          </script>";
}

mysqli_close($con);
?>
