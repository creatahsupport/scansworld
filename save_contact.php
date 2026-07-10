<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("includes/config.php");
include_once("mail/mail.php");
require_once("includes/google_sheets.php");

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

    // Validate Branch ID
    $branch_id_raw = intval($_POST['branch'] ?? 0);
    $branch_check_query = mysqli_query($con, "SELECT id FROM branch WHERE id = $branch_id_raw AND del_i = 0");
    if (mysqli_num_rows($branch_check_query) === 0) {
        http_response_code(400);
        echo "<script>alert('Invalid branch selected.'); window.history.back();</script>";
        exit;
    }

    // Validate Service ID
    $service_id_raw = intval($_POST['service'] ?? 0);
    $service_check_query = mysqli_query($con, "SELECT id FROM service WHERE id = $service_id_raw AND del_i = 0");
    if (mysqli_num_rows($service_check_query) === 0) {
        http_response_code(400);
        echo "<script>alert('Invalid service selected.'); window.history.back();</script>";
        exit;
    }

    // Validate Appointment Date (format YYYY-MM-DD)
    $date_raw = trim($_POST['date'] ?? '');
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date_raw)) {
        http_response_code(400);
        echo "<script>alert('Invalid date format. Must be YYYY-MM-DD.'); window.history.back();</script>";
        exit;
    }

    // Validate Appointment Time (numeric ID matching appointment_time table)
    $time_id = intval($_POST['time'] ?? 0);
    $time_query = mysqli_query($con, "SELECT time_value FROM appointment_time WHERE id = $time_id");
    if ($time_row = mysqli_fetch_assoc($time_query)) {
        $appointment_time_string = $time_row['time_value'];
        $appointment_time = (string) $time_id; // Store ID in database
    } else {
        http_response_code(400);
        echo "<script>alert('Invalid time selected.'); window.history.back();</script>";
        exit;
    }

    // Sanitize inputs
    $patient_name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $branch_id = htmlspecialchars(trim($_POST['branch']));
    $service_id = htmlspecialchars(trim($_POST['service']));
    $test_name = htmlspecialchars(trim($_POST['test_name'] ?? 'N/A'));
    $appointment_date = htmlspecialchars(trim($_POST['date']));
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

    // Determine Traffic Source
    $traffic_source = htmlspecialchars(trim($_POST['traffic_source'] ?? ''));
    if (empty($traffic_source)) {
        $traffic_source = "Direct";
        if (!empty($gclid) || !empty($gbraid) || stripos($utm_source, 'google') !== false || stripos($utm_source, 'ads') !== false) {
            $traffic_source = "Google Ads";
        } elseif (!empty($fbclid) || stripos($utm_source, 'facebook') !== false || stripos($utm_source, 'fb') !== false || stripos($utm_source, 'meta') !== false || stripos($utm_source, 'ig') !== false || stripos($utm_source, 'instagram') !== false) {
            $traffic_source = "Meta Ads";
        } elseif (stripos($utm_medium, 'organic') !== false || (!empty($referrer_url) && (stripos($referrer_url, 'google.com') !== false || stripos($referrer_url, 'bing.com') !== false || stripos($referrer_url, 'yahoo.com') !== false))) {
            $traffic_source = "Organic";
        } elseif (!empty($referrer_url)) {
            $traffic_source = "Referral";
        }
    }

    /* -----------------------------------------
       Convert IDs to names dynamically from DB
    ------------------------------------------*/
    $branch_map = [];
    $b_res = mysqli_query($con, "SELECT id, branch_name FROM branch where del_i=0 order by id desc");
    if ($b_res) {
        while ($b_row = mysqli_fetch_assoc($b_res)) {
            $branch_map[(string) $b_row['id']] = $b_row['branch_name'];
        }
    }

    $service_map = [];
    $s_res = mysqli_query($con, "SELECT id, service_name FROM service where del_i=0 order by id desc");
    if ($s_res) {
        while ($s_row = mysqli_fetch_assoc($s_res)) {
            $service_map[(string) $s_row['id']] = $s_row['service_name'];
        }
    }

    $branch_name = $branch_map[$branch_id] ?? "Unknown";
    $service_name = $service_map[$service_id] ?? "Unknown";


    $sql = "INSERT INTO book_appointment 
    (patient_name, phone, appointment_date, branch, appointment_time, service, test_name, enquiry_date, utm_source, utm_medium, utm_campaign, utm_term, utm_content, appointment_status, ip_address, landing_url, source, campaign_id, gclid, gbraid, fbclid, campaign_name, referrer_url, landing_page, traffic_source) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param(
        "ssssssssssssssssssssssss",
        $patient_name,
        $phone,
        $appointment_date,
        $branch_id,
        $appointment_time,
        $service_id,
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
        $new_id = $con->insert_id;

        // ── Push to Google Sheets ────────────────────────────
        pushToGoogleSheet([
            'id' => $new_id,
            'name' => $patient_name,
            'phone' => $phone,
            'branch' => $branch_name,
            'service' => $service_name,
            'appointment_date' => $appointment_date,
            'appointment_time' => $appointment_time_string,
            'enquiry_date' => $enquiry_date,
            'source' => $utm_source ?: 'Direct',
        ]);
        // ────────────────────────────────────────────────────

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
        <p><strong>Time:</strong> $appointment_time_string</p>
        <p><strong>Booking Date:</strong> $enquiry_date</p>";

        $to_email = "creatahmailinquiry@gmail.com";
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