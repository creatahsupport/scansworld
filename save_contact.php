<?php
include("includes/config.php");
include_once("mail/mail.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize inputs
    $patient_name     = htmlspecialchars(trim($_POST['name']));
    $phone            = htmlspecialchars(trim($_POST['phone']));
    $branch           = htmlspecialchars(trim($_POST['branch']));
    $service          = htmlspecialchars(trim($_POST['service']));
    $test_name        = htmlspecialchars(trim($_POST['test_name'] ?? 'N/A'));
    $appointment_date = htmlspecialchars(trim($_POST['date']));
    $appointment_time = htmlspecialchars(trim($_POST['time']));
    $enquiry_date     = date('Y-m-d');

    // Insert into DB (store names instead of IDs for now)
    $sql = "INSERT INTO book_appointment 
        (patient_name, phone, appointment_date, branch, appointment_time, service, enquiry_date, status, fees) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, 0, 0)";
    
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssss", $patient_name, $phone, $appointment_date, $branch, $appointment_time, $service, $enquiry_date);

    if ($stmt->execute()) {
        // Prepare email content
        $subject = "New Appointment Booking - Scans World";

        $message_content = "
        <h2>New Appointment Booking</h2>
        <p><strong>Patient Name:</strong> $patient_name</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Center:</strong> $branch</p>
        <p><strong>Service:</strong> $service</p>
        <p><strong>Test:</strong> $test_name</p>
        <p><strong>Date:</strong> $appointment_date</p>
        <p><strong>Time:</strong> $appointment_time</p>
        <p><strong>Booking Date:</strong> $enquiry_date</p>";

        // Send email
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
