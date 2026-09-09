<?php
include('../../config.php');

if (isset($_GET['img']) && isset($_GET['pid'])) {

    $img = mysqli_real_escape_string($con, $_GET['img']);
    $pid = (int) $_GET['pid'];

    $delete = "DELETE FROM floor_plane WHERE image='$img' AND property_id='$pid' LIMIT 1";
    mysqli_query($con, $delete);

    $filePath = "../../uploads/$img";
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    header("Location: editproperty?id=$pid");
    exit();
} else {
    echo "Invalid request.";
}
?>
