<?php
include('../components/auth.php');
include('../../config.php');

$id = $_GET['id'];
$current = $_GET['complete'];

$newStatus = $current == 1 ? 0 : 1;

$query = "UPDATE new_property SET project_type = $newStatus WHERE id = $id";
if (mysqli_query($con, $query)) {
    header("Location: new_property");
    exit();
} else {
    echo "Error updating completion status: " . mysqli_error($con);
}
?>
