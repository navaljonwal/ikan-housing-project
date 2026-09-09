<?php
include('../components/auth.php');
include('../../config.php');

header('Content-Type: application/json');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$current_status = isset($_GET['status']) ? intval($_GET['status']) : 0;

if ($id === 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid ID']);
    exit;
}

// Toggle status
$new_status = ($current_status == 1) ? 0 : 1;

$updateQuery = "UPDATE blog SET status = $new_status WHERE id = $id";

if (mysqli_query($con, $updateQuery)) {
    echo json_encode([
        'success' => true, 
        'new_status' => $new_status,
        'message' => 'Status updated successfully'
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Error updating status: ' . mysqli_error($con)
    ]);
}
?>
