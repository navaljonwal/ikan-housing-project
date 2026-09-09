<?php
include('../../config.php'); // config ka correct path

if (isset($_GET['id'])) {

    $id = intval($_GET['id']);

    // ✅ Delete SEO page
    $query = "DELETE FROM seo_pages WHERE id = $id";
    $result = mysqli_query($con, $query);

    if ($result) {
        // SEO list page par redirect
        header("Location: list");
        exit();
    } else {
        echo "Error deleting SEO record: " . mysqli_error($con);
    }

} else {
    echo "No ID provided.";
}
?>
