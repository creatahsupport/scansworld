<?php
header('Content-Type: application/json');
include("../includes/config.php");

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $fees = !empty($_POST['fees']) ? $_POST['fees'] : null;
    $follow_up_date = !empty($_POST['follow_up_date']) ? $_POST['follow_up_date'] : null;
    $comments = !empty($_POST['reason']) ? $_POST['reason'] : null;

    // SQL query to update data
    $sql = "UPDATE book_appointment 
            SET status = '$status', 
                fees = " . ($fees !== null ? "'$fees'" : "NULL") . ", 
                follow_up_date = " . ($follow_up_date !== null ? "'$follow_up_date'" : "NULL") . ", 
                comments = " . ($comments !== null ? "'$comments'" : "NULL") . " 
            WHERE id = '$id'";

    if ($con->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $con->error]);
    }
}

$con->close();
?>
