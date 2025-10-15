<?php
include("../includes/config.php");

// Get the banner ids, order ids, and type from the request
$banner_ids = json_decode($_POST['banner_ids']);
$order_ids = json_decode($_POST['order_ids']);
$type = $_POST['type'];  // Desktop or Mobile

// Check if the arrays are not empty
if (!empty($banner_ids) && !empty($order_ids)) {
    // Iterate through each banner id and its corresponding order_id
    for ($i = 0; $i < count($banner_ids); $i++) {
        $banner_id = $banner_ids[$i];
        $order_id = $order_ids[$i];

        // Update the order_id in the database
        $update_query = "UPDATE banner SET order_id = ? WHERE id = ? AND image_type = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, 'iis', $order_id, $banner_id, $type);
        mysqli_stmt_execute($stmt);
    }

    echo "Banner order updated successfully!";
} else {
    echo "Invalid data received!";
}
?>
