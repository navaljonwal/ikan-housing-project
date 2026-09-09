<?php
include('../components/auth.php');
include('../../config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$current_status = isset($_GET['status']) ? $_GET['status'] : 'Inactive';

// Toggle status
$new_status = ($current_status == 'Active') ? 'Inactive' : 'Active';

$updateQuery = "UPDATE testimonial SET status = '$new_status' WHERE id = $id";

if (mysqli_query($con, $updateQuery)) {
    header("Location: list");
    exit();
} else {
    echo "Error updating status: " . mysqli_error($con);
}
?>
