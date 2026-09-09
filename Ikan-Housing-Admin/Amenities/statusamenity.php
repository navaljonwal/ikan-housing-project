<?php
include('../components/auth.php');
include '../../config.php';

$id=$_GET['id'];
$status=$_GET['status'];

$querry="UPDATE amenity SET status=$status where id=$id";
$result=mysqli_query($con,$querry);
if($result){
    header('Location: listamenities');
}
?>