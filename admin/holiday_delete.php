<?php
include("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $holiday_id = $_POST['id'];
    $user_id = $_POST['user_id'];
        $update_sql = "UPDATE holiday SET del_i=1,deleted_by='$user_id'  where id='$holiday_id'";
        if (mysqli_query($con, $update_sql)) {
            echo "<script>alert('Holiday Deleted successfully!'); window.location.href='holiday.php';</script>";
        } else {
            echo "<script>alert('Error adding holiday: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill all required fields.');</script>";
    }

?>
