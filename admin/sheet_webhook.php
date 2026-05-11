<?php
/**
 * sheet_webhook.php
 * ─────────────────
 * Called by Google Apps Script when a user edits the Google Sheet.
 * Updates the book_appointment table with the new status/followup/reason.
 */

header('Content-Type: application/json');
include("../includes/config.php");

// ── Log everything to a debug file ───────────────────────────────────────────
$log_file = __DIR__ . '/webhook_debug.log';
function wlog($msg)
{
    global $log_file;
    file_put_contents($log_file, date('[Y-m-d H:i:s] ') . $msg . PHP_EOL, FILE_APPEND);
}

wlog("=== Request received ===");
wlog("Method: " . $_SERVER['REQUEST_METHOD']);
wlog("Received Secret Header: " . ($_SERVER['HTTP_X_WEBHOOK_SECRET'] ?? '(not set)'));
wlog("Expected Secret from ENV: " . ($_ENV['SHEET_WEBHOOK_SECRET'] ?? '(not set in ENV)'));

// ── Security: validate secret token ──────────────────────────────────────────
$expected_secret = $_ENV['SHEET_WEBHOOK_SECRET'] ?? '';
$received_secret = $_SERVER['HTTP_X_WEBHOOK_SECRET'] ?? '';

if (empty($expected_secret) || $received_secret !== $expected_secret) {
    wlog("FAILED: Secret mismatch. Expected=[$expected_secret] Got=[$received_secret]");
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Unauthorized']);
    exit;
}

// ── Only accept POST ──────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    wlog("FAILED: Not a POST request");
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// ── Parse JSON body ───────────────────────────────────────────────────────────
$body = file_get_contents('php://input');
wlog("Raw body received: " . $body);

$data = json_decode($body, true);

if (!$data || empty($data['id'])) {
    wlog("FAILED: Missing or invalid data. Body was: " . $body);
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing or invalid data']);
    exit;
}

$id = (int) $data['id'];
$status_label = trim($data['status'] ?? '');
$followup = trim($data['follow_up_date'] ?? '');
$reason = trim($data['reason'] ?? '');

wlog("Parsed → id=$id | status=[$status_label] | followup=[$followup] | reason=[$reason]");

// ── Map sheet status label → DB integer ──────────────────────────────────────
$status_map = [
    'Open' => 0,
    'Closed' => 1,
    'Not Turned Up' => 2,
    'Follow-up' => 3,
];

if (!array_key_exists($status_label, $status_map)) {
    wlog("FAILED: Invalid status value received: [$status_label]");
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid status value: ' . $status_label]);
    exit;
}

$status_int = $status_map[$status_label];
$followup_val = !empty($followup) ? $followup : null;
$reason_val = !empty($reason) ? $reason : null;

wlog("Mapped status [$status_label] → int [$status_int]");

// ── Check DB connection before querying ───────────────────────────────────────
if (!$con || $con->connect_error) {
    wlog("FATAL: DB connection failed — " . ($con->connect_error ?? 'null'));
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}
wlog("DB connection: OK");

// ── Update the DB ─────────────────────────────────────────────────────────────
// Disable strict MySQLi exceptions so prepare() returns false instead of crashing
mysqli_report(MYSQLI_REPORT_OFF);

$sql = "UPDATE book_appointment SET appointment_status = ?, follow_up_date = ?, reason = ? WHERE id = ?";
wlog("Calling prepare()...");

try {
    $stmt = $con->prepare($sql);
    wlog("prepare() result: " . ($stmt ? "OK" : "FAILED — " . $con->error));

    if (!$stmt) {
        wlog("HINT: 'status' / 'follow_up_date' / 'reason' columns may not exist. Run the ALTER migration!");
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $con->error]);
        exit;
    }

    wlog("Calling bind_param and execute()...");
    $stmt->bind_param("issi", $status_int, $followup_val, $reason_val, $id);

    if ($stmt->execute()) {
        $affected = $stmt->affected_rows;
        wlog("SUCCESS: Updated id=$id | affected_rows=$affected");
        echo json_encode(['success' => true, 'updated_id' => $id, 'affected_rows' => $affected]);
    } else {
        wlog("FAILED execute(): " . $stmt->error);
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();

} catch (Exception $e) {
    wlog("EXCEPTION caught: " . $e->getMessage());
    wlog("HINT: Run the ALTER migration — columns status/follow_up_date/reason may be missing!");
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Exception: ' . $e->getMessage()]);
}

$con->close();
wlog("=== Done ===");
?>