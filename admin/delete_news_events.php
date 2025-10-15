<?php
include("../includes/config.php"); 
$id = $_POST['id'];
$user_id = $_POST['user_id'];
$sql = "UPDATE news_events SET del_i=1,deleted_by='$user_id' where id=$id";

if (mysqli_query($con, $sql)) {
    echo "<script>
            alert('Data Deleted successfully.');
            window.location.href = 'news_events.php';
          </script>";
} else {
    echo "<script>
            alert('Error updating News & events: " . mysqli_error($con) . "');
            window.location.href = 'news_events.php';
          </script>";
}

mysqli_close($con);
?>
