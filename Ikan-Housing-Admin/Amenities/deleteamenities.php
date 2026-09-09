<?php
include('../components/auth.php');
include '../../config.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if(!$id){
    die("Invalid Id");
}

try {
    mysqli_begin_transaction($con);
    
    // Remove from many-to-many linking table
    mysqli_query($con, "DELETE FROM property_amenities WHERE amenity_id=$id");
    
    // Remove from properties table (if any property is directly linked)
    mysqli_query($con, "UPDATE properties SET amenity_id=NULL WHERE amenity_id=$id");

    // Delete the actual amenity
    $querry = "DELETE FROM amenity where id=$id";
    $result = mysqli_query($con, $querry);

    if($result){
        mysqli_commit($con);
        header('Location: listamenities');
        exit;
    } else {
        mysqli_rollback($con);
        die("Error in Deleting this icon: " . mysqli_error($con));
    }
} catch (mysqli_sql_exception $e) {
    mysqli_rollback($con);
    die("Database error: " . $e->getMessage());
}

mysqli_close($con);
?>