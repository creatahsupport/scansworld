<?php
include("includes/config.php");

$base_image = "uploads/doctor_images/";
$limit = 12;
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$start = ($page - 1) * $limit;

$RECENTSQL = "SELECT * FROM doctors WHERE status=1 ORDER BY id ASC LIMIT $start, $limit";
$RECENT_RESULT = mysqli_query($con, $RECENTSQL);

$response = [];

while ($row = mysqli_fetch_assoc($RECENT_RESULT)) {
    $response['doctors'][] = [
        'doctor_name' => htmlspecialchars($row['doctor_name']),
        'doctor_studies' => htmlspecialchars($row['doctor_studies']),
        'doctor_image' => htmlspecialchars($base_image . '/' . $row['doctor_image']),
        'image_alttag' => htmlspecialchars($row['image_alttag']),
        'doctor_content' => htmlspecialchars($row['doctor_content'])
    ];
}

$totalPostsSQL = "SELECT COUNT(*) as total FROM doctors WHERE status=1";
$totalPostsResult = mysqli_query($con, $totalPostsSQL);
$totalPosts = mysqli_fetch_assoc($totalPostsResult)['total'];
$totalPages = ceil($totalPosts / $limit);

$response['hasMore'] = ($page * $limit) < $totalPosts;

echo json_encode($response);
?>
