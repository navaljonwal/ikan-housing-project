<?php
session_start();
include '../../config.php';

// ✅ If already logged in, redirect
if (isset($_SESSION['admin_username'])) {
    header("Location: ../index");
    exit();
}

$error = ''; // Default empty

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM admin WHERE username='$username'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // ✅ Verify password
        if (password_verify($password, $row['password'])) {
            // ✅ Set all required session variables
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['admin_id'] = $row['id']; // 🔥 Add this line to fix profile page

            header("Location: ../index");
            exit();
        } else {
            $error = "Invalid password!";
        }
    } else {
        $error = "No such user found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ikanhousing-Admin-Login</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link
      rel="icon"
      href="../assets/img/kaiadmin/Ikanhousing-logo.svg"
      type="image/x-icon"
    />
</head>

<body>
  <div class="container">
    <form action="" class="main-form" method="POST">
      <div class="left">
        <h1>Hello, Welcome!</h1>
        <img src="../assets/img/Ikanhousing-logo-ng-1.svg" alt="Logo">
      </div>
      <div class="right">
        <h1>Login</h1>

        <!-- 🔴 Error Message Box -->
        <?php if (!empty($error)) { ?>
          <div class="alert alert-danger" style="margin: 10px 0;">
            <?php echo $error; ?>
          </div>
        <?php } ?>

        <div class="form-group">
          <i class="fa fa-user"></i>
          <input type="text" placeholder="Username" name="username" required>
        </div>

        <div class="form-group">
          <i class="fa fa-lock"></i>
          <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">Submit</button>
      </div>
    </form>
  </div>

  <script src="main.js"></script>
</body>

</html>
