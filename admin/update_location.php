<?php
include("../includes/config.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addlocation'])) {

    // Fetching data from the form
    $branch_id = $_POST['branch_id']; // Assuming branch ID is passed as a hidden field in the form
    $branch_name = $_POST['branch'];
    $fees = $_POST['fees'];
    $user_id = $_POST['user_id'];
    $to_email = $_POST['to_email'];
    $cc_email = $_POST['cc_mail'];
    $sms_number = $_POST['sms_number'];
    $status = $_POST['status'];
    $time_ids = isset($_POST['time']) ? implode(",", $_POST['time']) : '';
    $updated_date = date("Y-m-d H:i:s"); 

    // SQL query to update the branch details
    $sql = "UPDATE branch 
            SET branch_name = '$branch_name',
                fees = '$fees',
                to_email = '$to_email',
                cc_email = '$cc_email',
                sms_number = '$sms_number',
                branch_time = '$time_ids',
                status = '$status',
                update_date = '$updated_date',
                user_id = '$user_id'
            WHERE id = '$branch_id'";

    // Execute the query and handle the result
    if (mysqli_query($con, $sql)) {
        echo "<script>
                alert('Branch Updated Successfully.');
                window.location.href = 'branch.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    // Closing the database connection
    mysqli_close($con);
}
?>
