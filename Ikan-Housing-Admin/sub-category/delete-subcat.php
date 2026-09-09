<?php
include('../components/auth.php');
include('../../config.php');

$id=$_GET['id'] ?? null;
if(!$id){
    echo "Invalid id";
}

$querry="DELETE FROM sub_category WHERE id=$id";
$result=mysqli_query($con,$querry);
if($result){
    header("Location: sub-category");
}else{
    echo "Error in deleting this category";
}
?>