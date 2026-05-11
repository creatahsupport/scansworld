<?php
include("../includes/config.php");

if (isset($_POST['export_to_excel'])) {

    // Retrieve filters from POST
    $department = $_POST['department'] ?? 'service';
    $location = $_POST['location'] ?? 'centres';
    $enquiry_date = $_POST['enquiry_date'] ?? '';
    $enquiry_to_date = $_POST['enquiry_to_date'] ?? '';
    $appointment_date = $_POST['appointment_date'] ?? '';
    $appointment_to_date = $_POST['appointment_to_date'] ?? '';

    $whereClauses = [];

    // Date range filters
    if (!empty($enquiry_date) && !empty($enquiry_to_date)) {
        $converteddate = date("Y-m-d", strtotime($enquiry_date));
        $converteddate1 = date("Y-m-d", strtotime($enquiry_to_date));
        $whereClauses[] = "b.enquiry_date BETWEEN '$converteddate' AND '$converteddate1'";
    } elseif (!empty($appointment_date) && !empty($appointment_to_date)) {
        $converteddate = date("Y-m-d", strtotime($appointment_date));
        $converteddate1 = date("Y-m-d", strtotime($appointment_to_date));
        $whereClauses[] = "b.appointment_date BETWEEN '$converteddate' AND '$converteddate1'";
    }

    // Branch filter
    if ($location != "centres") {
        $whereClauses[] = "b.branch = '$location'";
    }

    // Service filter
    if ($department != "service") {
        $whereClauses[] = "b.service = '$department'";
    }

    // ✅ No need for JOIN — names are stored directly
    $sql = "
        SELECT 
            b.patient_name,
            b.phone,
            b.branch AS branch_name,
            b.service AS service_name,
            b.test_name,
            b.enquiry_date,
            b.appointment_date,
            b.appointment_time,
            t.time_value AS appointment_time_string,
            b.utm_source,
            b.utm_medium,
            b.utm_campaign,
            b.utm_term,
            b.utm_content
        FROM book_appointment b
        LEFT JOIN appointment_time t ON b.appointment_time = t.id
    ";

    if (!empty($whereClauses)) {
        $sql .= " WHERE " . implode(' AND ', $whereClauses);
    }

    $sql .= " ORDER BY b.id DESC";

    $result = mysqli_query($con, $sql);

    // Output Excel headers
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="Book_Appointment_Report.csv"');
    $output = fopen('php://output', 'w');

    // CSV Header
    fputcsv($output, [
        'Patient Name',
        'Phone',
        'Branch',
        'Service',
        'Test Name',
        'Enquiry Date',
        'Appointment Date',
        'Appointment Time',
        'UTM Source',
        'UTM Medium',
        'UTM Campaign',
        'UTM Term',
        'UTM Content'
    ]);

    // CSV Data
    $branch_map = [];
    $b_res = mysqli_query($con, "SELECT id, branch_name FROM branch");
    if ($b_res) {
        while ($b_row = mysqli_fetch_assoc($b_res)) {
            $branch_map[(string)$b_row['id']] = $b_row['branch_name'];
        }
    }

    $service_map = [];
    $s_res = mysqli_query($con, "SELECT id, service_name FROM service");
    if ($s_res) {
        while ($s_row = mysqli_fetch_assoc($s_res)) {
            $service_map[(string)$s_row['id']] = $s_row['service_name'];
        }
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $b_name = $branch_map[$row['branch_name']] ?? $row['branch_name'] ?? '-';
        $s_name = $service_map[$row['service_name']] ?? $row['service_name'] ?? '-';

        fputcsv($output, [
            $row['patient_name'] ?: '-',
            "\t" . $row['phone'], // forces Excel to keep full number
            $b_name,
            $s_name,
            $row['test_name'] ?: '-',
            !empty($row['enquiry_date']) ? date("d-m-Y", strtotime($row['enquiry_date'])) : '-',
            !empty($row['appointment_date']) ? date("d-m-Y", strtotime($row['appointment_date'])) : '-',
            (!empty($row['appointment_time_string']) ? $row['appointment_time_string'] : ($row['appointment_time'] ?: '-')),
            $row['utm_source'] ?: '-',
            $row['utm_medium'] ?: '-',
            $row['utm_campaign'] ?: '-',
            $row['utm_term'] ?: '-',
            $row['utm_content'] ?: '-'
        ]);
    }

    fclose($output);
    exit;
}
?>
