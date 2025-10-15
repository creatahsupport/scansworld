<?php
include("../includes/config.php"); 
$id = $_POST['id'];
$sql = "UPDATE settings SET  
            del_i=1 where id=$id";
if (mysqli_query($con, $sql)) {
    echo "<script>
            alert('Data Deleted successfully.');
            window.location.href = 'settings.php';
          </script>";
} else {
    echo "<script>
            alert('Error updating settings: " . mysqli_error($con) . "');
            window.location.href = 'settings.php';
          </script>";
}
mysqli_close($con);
?>
