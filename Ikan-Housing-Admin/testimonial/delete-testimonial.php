<?php
include('../../config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM `testimonial` WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
        header("Location: list"); // make sure this is correct
        exit();
    } else {
        echo "Error deleting: " . mysqli_error($con);
    }
} else {
    echo "No ID provided.";
}
?>
