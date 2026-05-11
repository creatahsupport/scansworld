<?php
/**
 * status_update.php
 * AJAX endpoint — updates appointment status, reason, followup_date in DB
 * and syncs the status change back to Google Sheets.
 *
 * Status values:
 *   0 = Open (default)
 *   1 = Closed
 *   2 = Not Turned Up
 *   3 = Follow-up
 */
header('Content-Type: application/json');
include("../includes/config.php");
require_once("../includes/google_sheets.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$status = (int) ($_POST['status'] ?? 0);
$followup_date = !empty($_POST['follow_up_date']) ? $_POST['follow_up_date'] : null;
$reason = !empty($_POST['reason']) ? trim($_POST['reason']) : null;

if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid appointment ID']);
    exit;
}

// Validate status
$allowed_statuses = [0, 1, 2, 3];
if (!in_array($status, $allowed_statuses, true)) {
    echo json_encode(['success' => false, 'error' => 'Invalid status value']);
    exit;
}

// followup_date is required when status = 3
if ($status === 3 && empty($followup_date)) {
    echo json_encode(['success' => false, 'error' => 'Follow-up date is required for Follow-up status']);
    exit;
}

// Build prepared UPDATE
$sql = "UPDATE book_appointment
        SET appointment_status = ?,
            follow_up_date = ?,
            reason        = ?
        WHERE id = ?";

$stmt = $con->prepare($sql);
$stmt->bind_param("issi", $status, $followup_date, $reason, $id);

if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'error' => $stmt->error]);
    $stmt->close();
    exit;
}
$stmt->close();

// ── Fetch row to sync back to Google Sheets ──────────────────
$status_labels = [0 => 'Open', 1 => 'Closed', 2 => 'Not Turned Up', 3 => 'Follow-up'];

$row_stmt = $con->prepare(
    "SELECT id, patient_name, phone, branch, service, appointment_date,
            appointment_time, enquiry_date, utm_source, appointment_status, follow_up_date, reason
     FROM book_appointment WHERE id = ?"
);
$row_stmt->bind_param("i", $id);
$row_stmt->execute();
$row = $row_stmt->get_result()->fetch_assoc();
$row_stmt->close();

if ($row) {
    pushToGoogleSheet([
        'action' => 'status_update',
        'id' => $row['id'],
        'name' => $row['patient_name'],
        'phone' => $row['phone'],
        'branch' => $row['branch'],
        'service' => $row['service'],
        'appointment_date' => $row['appointment_date'],
        'appointment_time' => $row['appointment_time'],
        'enquiry_date' => $row['enquiry_date'],
        'source' => $row['utm_source'] ?: 'Direct',
        'status' => $status_labels[$row['appointment_status']] ?? 'Unknown',
        'follow_up_date' => $row['follow_up_date'],
        'reason' => $row['reason'],
    ]);
}

echo json_encode(['success' => true]);
$con->close();
?>