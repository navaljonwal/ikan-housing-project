<?php
include('../components/auth.php');
include('../../config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$current_status = isset($_GET['status']) ? intval($_GET['status']) : 0;

// Toggle status
$new_status = ($current_status == 1) ? 0 : 1;

$updateQuery = "UPDATE new_property SET status = $new_status WHERE id = $id";

if (mysqli_query($con, $updateQuery)) {
    header("Location: new_property");
} else {
    echo "Error updating status: " . mysqli_error($con);
}
?>
