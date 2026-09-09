<?php
session_start();
include '../../config.php';

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login/login");
    exit();
}

// ✅ Safely fetch admin_id from session
$admin_id = $_SESSION['admin_id'] ?? null;

if (!$admin_id) {
    echo "<script>alert('Session expired or invalid access. Please login again.'); window.location.href = '../login/login.php';</script>";
    exit();
}

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $password = $_POST['password'];
    $confirm = $_POST['updatePassword'];

    if (!empty($password)) {
        if ($password !== $confirm) {
            echo "<script>alert('Passwords do not match');</script>";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $update_query = "UPDATE admin SET username = '$name', password = '$hashedPassword' WHERE id = '$admin_id'";
            if (mysqli_query($con, $update_query)) {
                echo "<script>alert('Profile updated successfully!');</script>";
            } else {
                echo "<script>alert('Update failed.');</script>";
            }
        }
    } else {
        $update_query = "UPDATE admin SET username = '$name' WHERE id = '$admin_id'";
        if (mysqli_query($con, $update_query)) {
            echo "<script>alert('Name updated successfully!');</script>";
        } else {
            echo "<script>alert('Name update failed.');</script>";
        }
    }
}

// ✅ Fetch admin data from database
$query = "SELECT * FROM admin WHERE id = '$admin_id'";
$result = mysqli_query($con, $query);
$admin = mysqli_fetch_assoc($result);

// ✅ If query failed or no data
if (!$admin) {
    echo "<script>alert('Failed to fetch admin details. Please login again.'); window.location.href = '../login/login.php';</script>";
    exit();
}

$username = htmlspecialchars($admin['username']);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>

<head>
    <meta charset="utf-8">
    <title>Update Profile</title>
</head>

<body>
    <div class="wrapper">
        <?php include('../components/viewSidebar.php'); ?>
        <div class="main-panel">
            <?php include('../components/viewNavbar.php'); ?>
            <div class="container">
                <div class="page-inner">
                    <div class="page-header">
                        <h3 class="fw-bold mb-3">Update Profile</h3>
                    </div>

                    <div class="container-pri">
                        <div class="profile-header-pri">
                            <h2>Your Profile</h2>
                            <div class="profile-info-pri show-pri">
                                <div class="info-text-pri">
                                    <h3><?php echo $username; ?></h3>
                                </div>
                            </div>
                        </div>

                        <div class="update-profile-pri">
                            <h2>Update Your Profile</h2>
                            <form id="profile-form-pri" method="POST" action="">
                                <div class="form-group-pri">
                                    <label for="name">Name</label>
                                    <div class="input-icon-pri">
                                        <i class="fa fa-user"></i>
                                        <input type="text" id="name" name="name" value="<?php echo $username; ?>" required>
                                    </div>
                                </div>

                                <div class="form-group-pri">
                                    <label for="password">New Password</label>
                                    <div class="input-icon-pri">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" id="password" name="password" placeholder="Enter new password">
                                    </div>
                                </div>

                                <div class="form-group-pri">
                                    <label for="updatePassword">Confirm Password</label>
                                    <div class="input-icon-pri">
                                        <i class="fa fa-lock"></i>
                                        <input type="password" id="updatePassword" name="updatePassword" placeholder="Confirm password">
                                    </div>
                                </div>

                                <button type="submit" class="submit-btn-pri">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include('../components/viewFooter.php'); ?>
            </div>
        </div>
    </div>
</body>

</html>
