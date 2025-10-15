<?php
 include("../includes/config.php"); 
include_once("include/header.php");
$today_date= date("Y-m-d");
if($user_name =='admin'){

$sql="Select count(*) as book_appointment_count from book_appointment";
$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $book_appointment_count = mysqli_fetch_assoc($result);
    $book_appointment_count = htmlspecialchars($book_appointment_count['book_appointment_count']);
} 
$sql1="Select count(*) as today_count from book_appointment where appointment_date='$today_date'";
$result1 = mysqli_query($con, $sql1);
if ($result1 && mysqli_num_rows($result1) > 0) {
    $today_booking_count = mysqli_fetch_assoc($result1);
    $today_booking_count = htmlspecialchars($today_booking_count['today_count']);
} 
$sql2="Select count(*) as today_turned from book_appointment where appointment_date='$today_date' and status=1";
$result2 = mysqli_query($con, $sql2);
if ($result2 && mysqli_num_rows($result2) > 0) {
    $today_turned = mysqli_fetch_assoc($result2);
    $today_turned = htmlspecialchars($today_turned['today_turned']);
} 
$sql3="Select count(*) as today_not_turned from book_appointment where appointment_date='$today_date' and status=0";
$result3 = mysqli_query($con, $sql3);
if ($result3 && mysqli_num_rows($result3) > 0) {
    $today_not_turned = mysqli_fetch_assoc($result3);
    $today_not_turned = htmlspecialchars($today_not_turned['today_not_turned']);
} 
$sql4 = "SELECT * FROM book_appointment WHERE status = 1";
$result4 = mysqli_query($con, $sql4);
$total_fees = 0;
if ($result4 && mysqli_num_rows($result4) > 0) {
    while ($row = mysqli_fetch_assoc($result4)) {
        if (isset($row['fees'])) {
            $total_fees += $row['fees'];
        }
    }
    $total_fees = htmlspecialchars($total_fees);
}
// Assuming you have a database connection in $conn

$query = "
    SELECT 
        b.branch_name,
        COUNT(ba.id) AS appointment_count
    FROM 
        book_appointment ba
    JOIN 
        branch b ON ba.branch= b.id
    WHERE 
        ba.appointment_date >= CURDATE() - INTERVAL 6 MONTH
    GROUP BY 
        b.branch_name
    ORDER BY 
        b.branch_name;
";

$result = mysqli_query($con, $query);

// Initialize an array to store chart data
$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Check if the branch name already exists in the labels array
    if (!in_array($row['branch_name'], $labels)) {
        $labels[] = $row['branch_name']; // Add branch name
        $data[] = $row['appointment_count']; // Add appointment count
    }
}

// Convert the PHP arrays to JSON for use in JavaScript
$labels_json = json_encode($labels);
$data_json = json_encode($data);

$query = "
    SELECT 
        b.branch_name,
        COUNT(ba.id) AS total_count,  -- Total number of bookings
        SUM(CASE WHEN ba.status = 1 THEN 1 ELSE 0 END) AS turned_count,  -- Number of turned appointments
        SUM(CASE WHEN ba.status = 0 THEN 1 ELSE 0 END) AS not_turned_count,  -- Number of not turned appointments
        SUM(CASE WHEN ba.status = 2 THEN 1 ELSE 0 END) AS follow_up  -- 
    FROM 
        book_appointment ba
    JOIN 
        branch b ON ba.branch = b.id
    GROUP BY 
        b.branch_name
    ORDER BY 
        b.branch_name;
";


// Execute the query
$result = mysqli_query($con, $query);
}else{
  $sql10 = "SELECT branch_id FROM admin WHERE user_name = '$user_name'";
  $result10 = mysqli_query($con, $sql10);

  if ($result10 && mysqli_num_rows($result10) > 0) {
      $row = mysqli_fetch_assoc($result10); 
      $branch_id = $row['branch_id'];
  }
//user based data 
$sql="Select count(*) as book_appointment_count from book_appointment where branch='$branch_id'";
// print_r($sql);die;
$result = mysqli_query($con, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $book_appointment_count = mysqli_fetch_assoc($result);
    $book_appointment_count = htmlspecialchars($book_appointment_count['book_appointment_count']);
} 
$sql1="Select count(*) as today_count from book_appointment where appointment_date='$today_date' and branch='$branch_id'";
$result1 = mysqli_query($con, $sql1);
if ($result1 && mysqli_num_rows($result1) > 0) {
    $today_booking_count = mysqli_fetch_assoc($result1);
    $today_booking_count = htmlspecialchars($today_booking_count['today_count']);
} 
$sql2="Select count(*) as today_turned from book_appointment where appointment_date='$today_date' and status=1 and branch='$branch_id'";
$result2 = mysqli_query($con, $sql2);
if ($result2 && mysqli_num_rows($result2) > 0) {
    $today_turned = mysqli_fetch_assoc($result2);
    $today_turned = htmlspecialchars($today_turned['today_turned']);
} 
$sql3="Select count(*) as today_not_turned from book_appointment where appointment_date='$today_date' and status=0 and branch='$branch_id'";
$result3 = mysqli_query($con, $sql3);
if ($result3 && mysqli_num_rows($result3) > 0) {
    $today_not_turned = mysqli_fetch_assoc($result3);
    $today_not_turned = htmlspecialchars($today_not_turned['today_not_turned']);
} 
$sql4 = "SELECT * FROM book_appointment WHERE status = 1 and branch='$branch_id'";
$result4 = mysqli_query($con, $sql4);
$total_fees = 0;
if ($result4 && mysqli_num_rows($result4) > 0) {
    while ($row = mysqli_fetch_assoc($result4)) {
        if (isset($row['fees'])) {
            $total_fees += $row['fees'];
        }
    }
    $total_fees = htmlspecialchars($total_fees);
}
// Assuming you have a database connection in $conn

$query = "
    SELECT 
        b.branch_name,
        COUNT(ba.id) AS appointment_count
    FROM 
        book_appointment ba
    JOIN 
        branch b ON ba.branch= b.id
    WHERE 
        ba.appointment_date >= CURDATE() - INTERVAL 6 MONTH and ba.branch='$branch_id'
    GROUP BY 
        b.branch_name
    ORDER BY 
        b.branch_name;
";

$result = mysqli_query($con, $query);

// Initialize an array to store chart data
$labels = [];
$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    // Check if the branch name already exists in the labels array
    if (!in_array($row['branch_name'], $labels)) {
        $labels[] = $row['branch_name']; // Add branch name
        $data[] = $row['appointment_count']; // Add appointment count
    }
}

// Convert the PHP arrays to JSON for use in JavaScript
$labels_json = json_encode($labels);
$data_json = json_encode($data);

$query = "
    SELECT 
        b.branch_name,
        COUNT(ba.id) AS total_count,  -- Total number of bookings
        SUM(CASE WHEN ba.status = 1 THEN 1 ELSE 0 END) AS turned_count,  -- Number of turned appointments
        SUM(CASE WHEN ba.status = 0 THEN 1 ELSE 0 END) AS not_turned_count,  -- Number of not turned appointments
        SUM(CASE WHEN ba.status = 2 THEN 1 ELSE 0 END) AS follow_up  -- 
    FROM 
        book_appointment ba
    JOIN 
        branch b ON ba.branch = b.id
        where 
         ba.branch='$branch_id'
    GROUP BY 
        b.branch_name
    ORDER BY 
        b.branch_name;
";


// Execute the query
$result = mysqli_query($con, $query);
}
?>