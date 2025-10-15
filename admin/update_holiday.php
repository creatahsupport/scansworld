<?php
include("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $holiday_id = $_POST['id'];
    $holiday_date = $_POST['holiday'];
    $user_id = $_POST['user_id'];
    $branches = isset($_POST['city']) ? $_POST['city'] : [];
    $times = isset($_POST['time']) ? $_POST['time'] : [];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $update_date = date("Y-m-d H:i:s");
    $branch_ids = implode(',', $branches);
    $time_ids = implode(',', $times);

    if (!empty($holiday_date) && !empty($branches) && !empty($times) && !empty($description)) {
        
        $update_sql = "UPDATE holiday SET holiday_date = '$holiday_date', description = '$description', update_date = '$update_date' , branch_id = '$branch_ids' ,time_slot = '$time_ids',user_id='$user_id' where id='$holiday_id'";
        if (mysqli_query($con, $update_sql)) {
            echo "<script>alert('Holiday Updated successfully!'); window.location.href='holiday.php';</script>";
        } else {
            echo "<script>alert('Error adding holiday: " . mysqli_error($con) . "');</script>";
        }
    } else {
        echo "<script>alert('Please fill all required fields.');</script>";
    }
} else {
    echo "<script>alert('Invalid form submission.');</script>";
}
?>
