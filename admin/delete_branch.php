<?php
include("../includes/config.php"); 

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $user_id = $_POST['user_id'];
    $id = mysqli_real_escape_string($con, $id);

    $sql = "UPDATE branch SET del_i = 1 ,deleted_by='$user_id' WHERE id = '$id'";

    if (mysqli_query($con, $sql)) {
        echo "<script>
                alert('Data Deleted Successfully.');
                window.location.href = 'branch.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting location: " . mysqli_error($con) . "');
                window.location.href = 'branch.php';
              </script>";
    }

    mysqli_close($con);
} else {
    echo "<script>
            alert('No ID provided.');
            window.location.href = 'branch.php';
          </script>";
}
?>
