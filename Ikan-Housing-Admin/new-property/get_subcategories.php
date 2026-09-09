<?php
include('../../config.php');

$cat_id = $_GET['cat_id'] ?? null;

if (!$cat_id) {
    echo json_encode(['success' => false, 'message' => 'Category ID missing']);
    exit;
}

$cat_id = mysqli_real_escape_string($con, $cat_id);
$query = "SELECT id, name FROM sub_category WHERE cat_id = '$cat_id' AND status = 1 ORDER BY name ASC";
$result = mysqli_query($con, $query);

$subcategories = [];
while ($row = mysqli_fetch_assoc($result)) {
    $subcategories[] = $row;
}

header('Content-Type: application/json');
echo json_encode(['success' => true, 'data' => $subcategories]);
?>
