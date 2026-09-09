<?php
ob_start();
session_start();
include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $slug  = isset($_POST['slug']) ? trim($_POST['slug']) : '';

    if (!preg_match('/^\d{10}$/', $phone)) {
        $_SESSION['error'] = 'Invalid mobile number.';
        header("Location: ../property-detail-for?slug=" . urlencode($slug));
        exit;
    }
  
    $stmt = $con->prepare("SELECT project_name FROM new_property WHERE slug = ? LIMIT 1");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if ($row) {
        $project_name = $row['project_name'];
    
        $insert_stmt = $con->prepare("INSERT INTO modal_contact (phone_no, property) VALUES (?, ?)");
        $insert_stmt->bind_param("ss", $phone, $project_name);
        if ($insert_stmt->execute()) {
           setcookie('mobile_submitted', '1', time() + (30 * 24 * 60 * 60), "/", "", false, false);
           $_SESSION['mobile_submitted'] = true;
           $_SESSION['visitor_mobile'] = $phone;
           header("Location: ../property-detail-for?slug=" . urlencode($slug));
           exit;
        } else {
            echo "Error saving data: " . $con->error;
        }
        $insert_stmt->close();
    } else {
        echo "Invalid property!";
    }
} else {
    header("Location: ../index");
    exit;
}
?>
