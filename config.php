<?php
ob_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('upload_max_filesize', '10M');  // Set maximum file size to 10MB
ini_set('post_max_size', '10M');        // Set maximum POST size to 10MB
ini_set('max_execution_time', '300');

$server = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "ikan-housing";

$con = mysqli_connect($server, $username, $password, $dbname);
if (!$con) {
    echo "not connected";
}
?>