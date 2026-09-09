<?php
include('../../config.php'); // correct path to your config

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM blog WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
        header("Location: list");
        exit();
    } else {
        echo "Error deleting blog: " . mysqli_error($con);
    }
} else {
    echo "No ID provided.";
}
?>
