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
            b.appointment_time
        FROM book_appointment b
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
        'Appointment Time'
    ]);

    // CSV Data
    while ($row = mysqli_fetch_assoc($result)) {
        fputcsv($output, [
            $row['patient_name'] ?: '-',
            "\t" . $row['phone'], // forces Excel to keep full number
            $row['branch_name'] ?: '-',
            $row['service_name'] ?: '-',
            $row['test_name'] ?: '-',
            !empty($row['enquiry_date']) ? date("d-m-Y", strtotime($row['enquiry_date'])) : '-',
            !empty($row['appointment_date']) ? date("d-m-Y", strtotime($row['appointment_date'])) : '-',
            $row['appointment_time'] ?: '-'
        ]);
    }

    fclose($output);
    exit;
}
?>
