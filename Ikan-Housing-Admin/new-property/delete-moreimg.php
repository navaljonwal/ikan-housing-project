<?php
include('../components/auth.php');
include('../../config.php');

$img_id = $_GET['id'] ?? null;          // button se aaya hua id
$property_id = $_GET['property_id'] ?? null;

if (!$img_id || !$property_id) {
    die("❌ Invalid request");
}

// Step 1: Get image filename
$sql = "SELECT image FROM property_img WHERE I_id = '$img_id' AND property_id = '$property_id'";
$result = mysqli_query($con, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    $filePath = "../../uploads/" . $row['image'];

    // Step 2: Delete file if it exists
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // Step 3: Delete DB record
    mysqli_query($con, "DELETE FROM property_img WHERE I_id = '$img_id'");
}

// Step 4: Redirect back to same property edit page
header("Location: editproperty?id=$property_id");
exit;
?>

