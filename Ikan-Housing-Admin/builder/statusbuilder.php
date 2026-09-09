<?php
include('../components/auth.php');
include('../../config.php');

$id=$_GET['id'] ?? null;
$status=$_GET['status'] ?? null;
if(!$id){
    echo "Invalid id";
}
$querry="UPDATE builder SET status='$status' where id=$id";
$result=mysqli_query($con,$querry);
if($result){
    header("Location: builder");
}else{
    echo "Not able to update status of this property";
}
?>
