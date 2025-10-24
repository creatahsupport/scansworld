<?php
include("includes/config.php");
include_once("mail/mail.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $patient_name     = htmlspecialchars(trim($_POST['name']));
    $phone            = htmlspecialchars(trim($_POST['phone']));
    $branch_id        = htmlspecialchars(trim($_POST['branch']));
    $service_id       = htmlspecialchars(trim($_POST['service']));
    $test_name        = htmlspecialchars(trim($_POST['test_name'] ?? 'N/A'));
    $appointment_date = htmlspecialchars(trim($_POST['date']));
    $appointment_time = htmlspecialchars(trim($_POST['time']));
    $enquiry_date     = date('Y-m-d');

    /* -----------------------------------------
       Convert IDs to names
    ------------------------------------------*/
    $branch_map = [
        "1" => "Nandanam",
        "2" => "Nanganallur",
        "3" => "Aminjikarai"
    ];

    $service_map = [
        "1" => "MRI",
        "2" => "CT",
        "3" => "X-Ray",
        "4" => "ECG"
    ];

    $branch_name  = $branch_map[$branch_id]  ?? "Unknown";
    $service_name = $service_map[$service_id] ?? "Unknown";

    /* -----------------------------------------
       ✅ Insert into database (removed fees)
    ------------------------------------------*/
    $sql = "INSERT INTO book_appointment 
        (patient_name, phone, appointment_date, branch, appointment_time, service, test_name, enquiry_date, appointment_status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        "ssssssss",
        $patient_name,
        $phone,
        $appointment_date,
        $branch_name,
        $appointment_time,
        $service_name,
        $test_name,
        $enquiry_date
    );

    if ($stmt->execute()) {
        // Email notification
        $subject = "New Appointment Booking - Scans World";

        $message_content = "
        <h2>New Appointment Booking</h2>
        <p><strong>Patient Name:</strong> $patient_name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Center:</strong> $branch_name</p>
        <p><strong>Service:</strong> $service_name</p>
        <p><strong>Test:</strong> $test_name</p>
        <p><strong>Date:</strong> $appointment_date</p>
        <p><strong>Time:</strong> $appointment_time</p>
        <p><strong>Booking Date:</strong> $enquiry_date</p>";

        $to_email = "creatahmailinquiry@gmail.com";
        mailer($subject, $message_content, $to_email);

        echo "<script>window.location.href='thank-you.php';</script>";
    } else {
        echo "Database Error: " . $stmt->error;
    }

    $stmt->close();
}
$con->close();
?>
