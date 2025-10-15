<?php include("includes/config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    body { font-family: "Roboto", sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
    .container { width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; }
    .header { background-color: #0073aa; padding: 20px; color: #fff; text-align: center; }
    .header img { height: 60px; }
    .content { padding: 20px; color: #333; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
    th { background-color: #f2f2f2; width: 35%; }
    .footer { background: #f9f9f9; text-align: center; padding: 15px; font-size: 14px; color: #666; }
</style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="<?php echo $url_config; ?>/assets/scan-world/logo.png" alt="Scans World">
        <h2>New Appointment Booking</h2>
    </div>

    <div class="content">
        <p>Dear Admin,</p>
        <p>A new appointment booking has been submitted with the following details:</p>
        <table>
            <tr><th>Patient Name</th><td><?= htmlspecialchars($patient_name) ?></td></tr>
            <!-- <tr><th>Email ID</th><td><?= htmlspecialchars($email_id) ?></td></tr> -->
            <tr><th>Phone</th><td><?= htmlspecialchars($phone) ?></td></tr>
           <tr><th>Center</th><td><?= htmlspecialchars($branch) ?></td></tr>
<tr><th>Service</th><td><?= htmlspecialchars($service) ?></td></tr>

            <tr><th>Appointment Date</th><td><?= htmlspecialchars($appointment_date) ?></td></tr>
            <tr><th>Appointment Time</th><td><?= htmlspecialchars($appointment_time) ?></td></tr>
            <tr><th>Enquiry Date</th><td><?= htmlspecialchars($enquiry_date) ?></td></tr>
        </table>
        <p>Please follow up with the patient at the earliest.</p>
    </div>

    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> Scans World | All Rights Reserved</p>
    </div>
</div>
</body>
</html>
