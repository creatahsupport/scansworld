<?php
include("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $holiday_date = $_POST['holiday'];
    $user_id = $_POST['user_id'];
    $branches = isset($_POST['city']) ? $_POST['city'] : [];
    $times = isset($_POST['time']) ? $_POST['time'] : [];
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $created_date = date("Y-m-d H:i:s");
    $branch_ids = implode(',', $branches);
    $time_ids = implode(',', $times);

    if (!empty($holiday_date) && !empty($branches) && !empty($times) && !empty($description)) {
        
        $sql = "INSERT INTO holiday (holiday_date, branch_id, time_slot, description, created_date,user_id)
                VALUES ('$holiday_date', '$branch_ids', '$time_ids', '$description', '$created_date','$user_id')";

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Holiday added successfully!'); window.location.href='holiday.php';</script>";
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
