<?php
include('../components/auth.php');
include('../../config.php');

$property_id = $_GET['id'];

// pehle child records delete kar
mysqli_query($con, "DELETE FROM property_img WHERE property_id = '$property_id'");
mysqli_query($con, "DELETE FROM property_amenities WHERE property_id = '$property_id'");

// phir parent record delete kar
$result = mysqli_query($con, "DELETE FROM new_property WHERE id = '$property_id'");

if ($result) {
    header('Location: new_property');
    exit;
} else {
    echo "Error in deleting property: " . mysqli_error($con);
}
?>
