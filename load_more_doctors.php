<?php
include("includes/config.php");

header('Content-Type: application/json');

$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$limit = 12;
$start = ($page - 1) * $limit;

// Get total count of active doctors
$totalSQL = "SELECT COUNT(*) as total FROM doctors WHERE status = 1 AND del_i = 0";
$totalResult = mysqli_query($con, $totalSQL);

if (!$totalResult) {
    echo json_encode([
        'error' => 'Database error: ' . mysqli_error($con),
        'doctors' => [],
        'hasMore' => false
    ]);
    exit;
}

$total = mysqli_fetch_assoc($totalResult)['total'];
$totalPages = ceil($total / $limit);

// Fetch doctors for this page
$sql = "SELECT * FROM doctors WHERE status = 1 AND del_i = 0 ORDER BY id ASC LIMIT $start, $limit";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode([
        'error' => 'Database error: ' . mysqli_error($con),
        'doctors' => [],
        'hasMore' => false
    ]);
    exit;
}

$doctors = [];
$base_image = "uploads/doctor_images/";

while ($row = mysqli_fetch_assoc($result)) {
    $doctors[] = [
        'doctor_name' => htmlspecialchars($row['doctor_name']),
        'doctor_studies' => htmlspecialchars($row['doctor_studies']),
        'doctor_image' => $base_image . htmlspecialchars($row['doctor_image']),
        'image_alttag' => htmlspecialchars($row['image_alttag']),
        'doctor_content' => htmlspecialchars($row['doctor_content'])
    ];
}

echo json_encode([
    'doctors' => $doctors,
    'hasMore' => ($page < $totalPages),
    'currentPage' => $page,
    'totalPages' => $totalPages,
    'totalDoctors' => $total
]);
?>