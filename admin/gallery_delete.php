<?php
include("../includes/config.php"); 



$id = $_POST['id'];
$user_id = $_POST['user_id'];

$sql = "UPDATE gallery_management SET  del_i=1,deleted_by='$user_id' where id=$id";

if (mysqli_query($con, $sql)) {
    echo "<script>
            alert('Gallery Deleted successfully.');
            window.location.href = 'gallery.php';
          </script>";
} else {
    echo "<script>
            alert('Error updating settings: " . mysqli_error($con) . "');
            window.location.href = 'gallery.php';
          </script>";
}

mysqli_close($con);
?>
