<?php
session_start();
include('../config.php'); 

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
    $age = isset($_POST['age']) ? trim($_POST['age']) : '';
    $experience = isset($_POST['experience']) ? trim($_POST['experience']) : '';
    $position = isset($_POST['position']) ? trim($_POST['position']) : '';

    if (empty($name) || empty($email) || empty($mobile) || empty($age) || empty($experience) || empty($position)) {
        $_SESSION['error'] = 'All fields are required.';
        header('Location: ../career');
        exit();
    }

    if (!validateEmail($email)) {
        $_SESSION['error'] = 'Invalid email format.';
        header('Location: ../career');
        exit();
    }

    if (!preg_match('/^\d{10}$/', $mobile)) {
        $_SESSION['error'] = 'Mobile number must be 10 digits.';
        header('Location: ../career');
        exit();
    }

    if (!is_numeric($age) || $age < 18) {
        $_SESSION['error'] = 'Age must be a valid number and at least 18.';
        header('Location: ../career');
        exit();
    }

    // File Upload Security Improvements
    $filePath = "";
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        $allowedExts = array("pdf", "doc", "docx");
        
        $fileName = $_FILES['resume']['name'];
        $tmpName  = $_FILES['resume']['tmp_name'];
        
        $temp = explode(".", $fileName);
        $extension = strtolower(end($temp));
        
        // Anti-shell check
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $tmpName);
        finfo_close($finfo);
        
        $allowedMimeTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        
        if (!in_array($extension, $allowedExts) || !in_array($mime, $allowedMimeTypes)) {
            $_SESSION['error'] = 'Invalid file type. Only PDF and Word documents are allowed.';
            header('Location: ../career');
            exit();
        }
        
        // Prevent path traversal and malicious overwriting by dynamically assigning a unique ID
        $newFileName = uniqid('resume_', true) . '.' . $extension;
        $uploadPath = '../uploads/' . $newFileName;
        
        if (!move_uploaded_file($tmpName, $uploadPath)) {
            $_SESSION['error'] = 'Error uploading the resume file.';
            header('Location: ../career');
            exit();
        }
        $filePath = $newFileName;
    } else {
        $_SESSION['error'] = 'Error with the resume upload. Please attach a file.';
        header('Location: ../career');
        exit();
    }

    // SQL Injection safe Prepared Statements
    $stmt = $con->prepare("INSERT INTO `resume_submissions` (`name`, `email`, `mobile`, `age`, `experience`, `position`, `resume_path`) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $email, $mobile, $age, $experience, $position, $filePath);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Your resume has been submitted successfully!';
    } else {
        $_SESSION['error'] = 'Error submitting your resume. Please try again.';
    }

    $stmt->close();
    header('Location: ../career');
    exit();
}

$con->close();
header('Location: ../career');
?>
