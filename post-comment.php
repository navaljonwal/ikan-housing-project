
<?php
include 'config.php';


/////////////Start 

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

$sql = "INSERT INTO `post-comment`(`name`, `phone`, `email`, `message`) VALUES ('$name','$phone','$email','$message')";


$result = mysqli_query($con, $sql);

$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");

