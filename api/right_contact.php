<?php
header("Content-Type: application/json");
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = isset($_POST['c_name']) ? trim($_POST['c_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

    if (!empty($customer_name) && !empty($phone)) {
        $stmt = $con->prepare("INSERT INTO right_contact (name, email, phone) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sss", $customer_name, $email, $phone);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database execution failed."]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Database statement failed."]);
        }
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Fields cannot be empty!"]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request!"]);
    exit();
}
?>
