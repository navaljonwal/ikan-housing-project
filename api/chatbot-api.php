<?php
header('Content-Type: application/json');
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? mysqli_real_escape_string($con, strip_tags($_POST['name'])) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($con, strip_tags($_POST['phone'])) : '';
    $service = isset($_POST['service']) ? mysqli_real_escape_string($con, strip_tags($_POST['service'])) : '';
    $page = isset($_POST['page']) ? mysqli_real_escape_string($con, strip_tags($_POST['page'])) : '';

    if (empty($name) || empty($phone)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
        exit;
    }

    $sql = "INSERT INTO chatbot_leads (name, phone, service_interest, page_source) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $name, $phone, $service, $page);
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success', 'message' => 'Lead saved successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Execution failed: ' . mysqli_stmt_error($stmt)]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Preparation failed: ' . mysqli_error($con)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
