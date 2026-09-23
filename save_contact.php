<?php
include("includes/config.php");
include_once("mail/mail.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify Cloudflare Turnstile
    $cf_turnstile_response = $_POST['cf-turnstile-response'] ?? '';
    global $cloudflare_secret_key;
    if (!verifyCloudflareTurnstile($cf_turnstile_response, $cloudflare_secret_key)) {
        http_response_code(403);
        echo "<script>alert('CloudFare verification failed. Please try again.'); window.history.back();</script>";
        exit;
    }

   // Check for blacklisted words
    global $blacklist_words;
    
    // Check only visible fields to prevent tracking parameters from triggering the blacklist
    $visible_fields = ['name', 'phone', 'test_name', 'message', 'subject', 'email'];
    $inputs_to_check = [];
    foreach ($visible_fields as $field) {
        if (isset($_POST[$field])) {
            $inputs_to_check[] = $_POST[$field];
        }
    }
    $all_inputs = implode(" ", $inputs_to_check);
    
    $detected_word = '';
    foreach ($blacklist_words as $word) {
        if (preg_match("/\b" . preg_quote($word, '/') . "\b/i", $all_inputs)) {
            $detected_word = $word;
            break;
        }
    }
    
    if ($detected_word !== '') {
        http_response_code(403);
        $escaped_word = addslashes(htmlspecialchars($detected_word, ENT_QUOTES, 'UTF-8'));
        echo "<script>alert('Invalid input detected. Restricted word used: " . $escaped_word . "'); window.history.back();</script>";
        exit;
    }

    // Backend validation matching frontend
    $raw_name = trim($_POST['name'] ?? '');
    $raw_phone = trim($_POST['phone'] ?? '');

    if (!preg_match('/^[a-zA-Z ]{3,50}$/', $raw_name)) {
        http_response_code(400);
        echo "<script>alert('Invalid name. Only letters and spaces are allowed'); window.history.back();</script>";
        exit;
    }

    if (!preg_match('/^[1-9][0-9]{9}$/', $raw_phone)) {
        http_response_code(400);
        echo "<script>alert('Invalid phone number. Must be exactly 10 digits.'); window.history.back();</script>";
        exit;
    }

    // Sanitize inputs
    $patient_name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $branch_id = htmlspecialchars(trim($_POST['branch']));
    $service_id = htmlspecialchars(trim($_POST['service']));
    $test_name = htmlspecialchars(trim($_POST['test_name'] ?? 'N/A'));
    $appointment_date = htmlspecialchars(trim($_POST['date']));
    $appointment_time = htmlspecialchars(trim($_POST['time']));
   $landing_url = htmlspecialchars(trim($_POST['landing_url'] ?? null));
    $source = htmlspecialchars(trim($_POST['source'] ?? null));
    $campaign_id = htmlspecialchars(trim($_POST['campaign_id'] ?? null));
    $gclid = htmlspecialchars(trim($_POST['gclid'] ?? null));
    $gbraid = htmlspecialchars(trim($_POST['gbraid'] ?? null));
    $fbclid = htmlspecialchars(trim($_POST['fbclid'] ?? null));
    $utm_source = htmlspecialchars(trim($_POST['utm_source'] ?? ''));
    $utm_medium = htmlspecialchars(trim($_POST['utm_medium'] ?? ''));
    $utm_campaign = htmlspecialchars(trim($_POST['utm_campaign'] ?? ''));
    $utm_term = htmlspecialchars(trim($_POST['utm_term'] ?? ''));
    $utm_content = htmlspecialchars(trim($_POST['utm_content'] ?? ''));
    $campaign_name = htmlspecialchars(trim($_POST['campaign_name'] ?? ''));
    $referrer_url = htmlspecialchars(trim($_POST['referrer_url'] ?? ''));
    $landing_page = htmlspecialchars(trim($_POST['landing_page'] ?? ''));
    $enquiry_date = date('Y-m-d');
    $ip_address = getUserIP();
    /* -----------------------------------------
       Convert IDs to names
    ------------------------------------------*/
    $branch_map = [
        "1" => "Nandanam",
        "2" => "Nanganallur",
        "3" => "Aminjikarai",
        "4" => "vellore"
    ];

    $service_map = [
        "1" => "Wide Bore 3 Tesla MRI Scan",
        "2" => "MRI Scan",
        "3" => "X-Ray",
        "4" => "ECG",
        "5" => "CT Scan",
        "6" => "PET - CT Scan",
        "7" => "3nethra Classic+",
    ];

    $branch_name = $branch_map[$branch_id] ?? "Unknown";
    $service_name = $service_map[$service_id] ?? "Unknown";


    $sql = "INSERT INTO book_appointment 
    (patient_name, phone, appointment_date, branch, appointment_time, service, test_name, enquiry_date, utm_source, utm_medium, utm_campaign, utm_term, utm_content, appointment_status,ip_address,landing_url, source, campaign_id, gclid, gbraid, fbclid, campaign_name, referrer_url, landing_page, traffic_source) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0,?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssssssssss",
        $patient_name,
        $phone,
        $appointment_date,
        $branch_name,
        $appointment_time,
        $service_name,
        $test_name,
        $enquiry_date,
        $utm_source,
        $utm_medium,
        $utm_campaign,
        $utm_term,
        $utm_content,
        $ip_address,
        $landing_url,
        $source,
        $campaign_id,
        $gclid,
        $gbraid,
        $fbclid,
        $campaign_name,
        $referrer_url,
        $landing_page,
        $traffic_source
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

        $to_email = $_ENV['To_Email'];
        mailer($subject, $message_content, $to_email);

        http_response_code(200);
        echo "<script>window.location.href='thank-you.php';</script>";
    } else {
        http_response_code(500);
        echo "Database Error: " . $stmt->error;
    }

    $stmt->close();
}
$con->close();
?>