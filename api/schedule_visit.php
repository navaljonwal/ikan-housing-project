<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $visit_date = isset($_POST['visit_date']) ? trim($_POST['visit_date']) : '';
    $time_slot = isset($_POST['time_slot']) ? trim($_POST['time_slot']) : '';
    $property_name = isset($_POST['property_name']) ? trim($_POST['property_name']) : '';
    $property_slug = isset($_POST['property_slug']) ? trim($_POST['property_slug']) : '';
    $property_id = isset($_POST['property_id']) && is_numeric($_POST['property_id']) ? (int)$_POST['property_id'] : 0;

    if (empty($property_name)) {
        $property_name = 'Property Visit';
    }

    if (empty($name) || empty($phone) || empty($visit_date) || empty($time_slot)) {
        echo json_encode([
            "status" => "error",
            "message" => "Please fill all required fields (Name, Phone, Date, and Time Slot)."
        ]);
        exit();
    }

    // Basic 10-digit phone validation
    if (!preg_match('/^[0-9]{10}$/', preg_replace('/[^0-9]/', '', $phone))) {
        echo json_encode([
            "status" => "error",
            "message" => "Please enter a valid 10-digit mobile number."
        ]);
        exit();
    }

    // Validate visit date is not in past
    $selected_timestamp = strtotime($visit_date);
    $today_timestamp = strtotime(date('Y-m-d'));
    if ($selected_timestamp === false || $selected_timestamp < $today_timestamp) {
        echo json_encode([
            "status" => "error",
            "message" => "Please select today or a future date for your site visit."
        ]);
        exit();
    }

    $stmt = $con->prepare("INSERT INTO site_visits (property_id, property_name, property_slug, name, phone, email, visit_date, time_slot, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'New')");
    if ($stmt) {
        $clean_phone = substr(preg_replace('/[^0-9]/', '', $phone), -10);
        $stmt->bind_param("isssssss", $property_id, $property_name, $property_slug, $name, $clean_phone, $email, $visit_date, $time_slot);
        
        if ($stmt->execute()) {
            echo json_encode([
                "status" => "success",
                "message" => "Your site visit for " . htmlspecialchars($property_name) . " has been scheduled for " . date('d M, Y', $selected_timestamp) . " (" . htmlspecialchars($time_slot) . "). Our property advisor will call you shortly to confirm."
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Could not schedule your visit right now. Please try again or call us directly."
            ]);
        }
        $stmt->close();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database statement preparation failed."
        ]);
    }
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit();
}
