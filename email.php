<?php
session_start();
include ('config.php');

header("Content-Type: application/json");

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Check for duplicate
        $check_stmt = $con->prepare("SELECT id FROM subscribe_us WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if ($check_stmt->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "This email is already subscribed. Thank you!"]);
            $check_stmt->close();
            exit();
        }
        $check_stmt->close();

        // Insert new subscription
        $stmt = $con->prepare("INSERT INTO `subscribe_us` (`email`) VALUES (?)");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Thank you for subscribing to our newsletter!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error occurred. Please try again later."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email format."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Email address cannot be empty."]);
}
?>