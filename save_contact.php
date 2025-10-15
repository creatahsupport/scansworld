<?php
include("includes/config.php");
include_once("mail/mail.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitize user inputs
$patient_name     = htmlspecialchars(trim($_POST['name']));
$phone            = htmlspecialchars(trim($_POST['phone']));
$branch           = htmlspecialchars(trim($_POST['branch']));  // Now stores actual name (e.g., "CAUTION DEPOSIT FOR CT/MRI")
$service          = htmlspecialchars(trim($_POST['service'])); // Stores "MRI", "CT", etc.
$appointment_date = htmlspecialchars(trim($_POST['date']));
$appointment_time = htmlspecialchars(trim($_POST['time']));
$enquiry_date     = date('Y-m-d');


    // Insert into DB
    $sql = "INSERT INTO book_appointment 
    (patient_name, phone, appointment_date, branch, appointment_time, service, enquiry_date, status, fees) 
    VALUES 
    ('$patient_name', '$phone', '$appointment_date', '$branch', '$appointment_time', '$service', '$enquiry_date', 0, 0)";

    if ($con->query($sql) === TRUE) {
        $subject = "New Appointment Booking - Scans World";

        // Generate email content
        ob_start();
        include("contact_us_email_template.php");
        $message_content = ob_get_clean();

        // Send email
        $to_email = "creatahmailinquiry@gmail.com";  // Change this to your recipient email
        $cc_email = ""; // optional
        mailer($subject, $message_content, $to_email, $cc_email);

        echo "<script>window.location.href='thank-you.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }
}

$con->close();
?>
