<?php
include("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addlocation'])) {
    
    $branch_name = $_POST['branch'];
    $fees = $_POST['fees'];
    $user_id = $_POST['user_id'];
    $to_email = $_POST['to_email'];
    $cc_email = $_POST['cc_mail'];
    $sms_number = $_POST['sms_number'];
    $status = $_POST['status'];
    $time_ids = isset($_POST['time']) ? implode(",", $_POST['time']) : '';
    $created_date = date("Y-m-d H:i:s"); 

    $sql = "INSERT INTO branch (branch_name, fees, to_email, cc_email, sms_number,branch_time, status, created_date,user_id) 
            VALUES ('$branch_name', '$fees', '$to_email', '$cc_email', '$sms_number','$time_ids', '$status', '$created_date','$user_id')";
// print_r($sql);die;
    if (mysqli_query($con, $sql)) {
        echo "<script>
                alert('Branch Added Successfully.');
                window.location.href = 'branch.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>

