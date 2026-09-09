<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header("Content-Type: application/json");

    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $subject = mysqli_real_escape_string($con, $_POST['subject']); // Mapping this to business_service_name
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $phone   = "Home Form"; // Placeholder for phone as home form doesn't have it

    $sql = "INSERT INTO contact (name, email, phone, message, business_service_name) 
            VALUES ('$name', '$email', '$phone', '$message', '$subject')";

    if ($con->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "msg" => $con->error]);
    }

    $con->close();
    exit;
}
?>
