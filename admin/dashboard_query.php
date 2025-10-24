<?php
include("../includes/config.php");
include_once("include/header.php");

$today_date = date("Y-m-d");
$total_fees = 0;

// Default values
$book_appointment_count = 0;
$today_booking_count = 0;
$today_turned = 0;
$today_not_turned = 0;
$total_blog_count = 0;
$total_doctor_count = 0;
$total_news_count = 0;

// ===================================================================
// ADMIN SECTION
// ===================================================================
if ($user_name == 'admin') {

    // Total Appointments
    $sql = "SELECT COUNT(*) AS count FROM book_appointment";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $book_appointment_count = (int)$row['count'];
    }

    // Today's Bookings
    $sql = "SELECT COUNT(*) AS count FROM book_appointment WHERE appointment_date='$today_date'";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $today_booking_count = (int)$row['count'];
    }

    // Today's Turned
    $sql = "SELECT COUNT(*) AS count FROM book_appointment WHERE appointment_date='$today_date' AND appointment_status=1";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $today_turned = (int)$row['count'];
    }

    // Today's Not Turned
    $sql = "SELECT COUNT(*) AS count FROM book_appointment WHERE appointment_date='$today_date' AND appointment_status=0";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $today_not_turned = (int)$row['count'];
    }

    // ✅ Total Fees (for turned appointments)
    $sql = "SELECT SUM(fees) AS total_fees FROM book_appointment WHERE appointment_status=1";
    // $result = mysqli_query($con, $sql);
    // if ($row = mysqli_fetch_assoc($result)) {
    //     $total_fees = (float)($row['total_fees'] ?? 0);
    // }

    // ✅ Total Blogs
    $sql = "SELECT COUNT(*) AS count FROM blog WHERE del_i = 0";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $total_blog_count = (int)$row['count'];
    }

    // ✅ Total Doctors
    $sql = "SELECT COUNT(*) AS count FROM doctors WHERE del_i = 0";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $total_doctor_count = (int)$row['count'];
    }

    // ✅ Total News & Events
    $sql = "SELECT COUNT(*) AS count FROM news WHERE del_i = 0";
    // $result = mysqli_query($con, $sql);
    // if ($row = mysqli_fetch_assoc($result)) {
    //     $total_news_count = (int)$row['count'];
    // }

    // ✅ Branch-wise appointments (last 6 months)
    $query = "
        SELECT 
            b.branch_name,
            COUNT(ba.id) AS appointment_count
        FROM 
            book_appointment ba
        LEFT JOIN 
            branch b ON b.id = ba.branch
        WHERE 
            ba.appointment_date >= CURDATE() - INTERVAL 6 MONTH
        GROUP BY 
            b.branch_name
        ORDER BY 
            b.branch_name;
    ";
    $result = mysqli_query($con, $query);

    $labels = [];
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['branch_name'];
        $data[] = $row['appointment_count'];
    }

    $labels_json = json_encode($labels, JSON_UNESCAPED_UNICODE);
    $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);
}

// ===================================================================
// NON-ADMIN (BRANCH USER) SECTION
// ===================================================================
else {
    $user_name = mysqli_real_escape_string($con, $user_name);
    $branch_id = '';

    // Get Branch ID from Admin table
    $sql = "SELECT branch_id FROM admin WHERE user_name='$user_name'";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $branch_id = $row['branch_id'];
    }

    // Total Appointments (Branch)
    $sql = "SELECT COUNT(*) AS count FROM book_appointment WHERE branch='$branch_id'";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $book_appointment_count = (int)$row['count'];
    }

    // Today's Bookings (Branch)
    $sql = "SELECT COUNT(*) AS count FROM book_appointment WHERE appointment_date='$today_date' AND branch='$branch_id'";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $today_booking_count = (int)$row['count'];
    }

    // Today's Turned (Branch)
    $sql = "SELECT COUNT(*) AS count FROM book_appointment WHERE appointment_date='$today_date' AND appointment_status=1 AND branch='$branch_id'";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $today_turned = (int)$row['count'];
    }

    // Today's Not Turned (Branch)
    $sql = "SELECT COUNT(*) AS count FROM book_appointment WHERE appointment_date='$today_date' AND appointment_status=0 AND branch='$branch_id'";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $today_not_turned = (int)$row['count'];
    }

    // ✅ Total Fees (Branch)
    $sql = "SELECT SUM(fees) AS total_fees FROM book_appointment WHERE appointment_status=1 AND branch='$branch_id'";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $total_fees = (float)($row['total_fees'] ?? 0);
    }

    // ✅ Total Blogs
    $sql = "SELECT COUNT(*) AS count FROM blog WHERE del_i = 0";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $total_blog_count = (int)$row['count'];
    }

    // ✅ Total Doctors
    $sql = "SELECT COUNT(*) AS count FROM doctors WHERE del_i = 0";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $total_doctor_count = (int)$row['count'];
    }

    // ✅ Total News & Events
    $sql = "SELECT COUNT(*) AS count FROM news WHERE del_i = 0";
    $result = mysqli_query($con, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $total_news_count = (int)$row['count'];
    }

    // ✅ Branch-wise chart (single branch)
    $query = "
        SELECT 
            b.branch_name,
            COUNT(ba.id) AS appointment_count
        FROM 
            book_appointment ba
        LEFT JOIN 
            branch b ON b.id = ba.branch
        WHERE 
            ba.appointment_date >= CURDATE() - INTERVAL 6 MONTH
            AND ba.branch='$branch_id'
        GROUP BY 
            b.branch_name;
    ";
    $result = mysqli_query($con, $query);

    $labels = [];
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['branch_name'];
        $data[] = $row['appointment_count'];
    }

    $labels_json = json_encode($labels, JSON_UNESCAPED_UNICODE);
    $data_json = json_encode($data, JSON_UNESCAPED_UNICODE);
}
?>
