<?php
include '../../config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password_raw = $_POST['password'];
    $confirm_password_raw = $_POST['confirm_password'];

    // Password Match Validation
    if ($password_raw !== $confirm_password_raw) {
        die("Passwords do not match!");
    }

    // Hash password
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO `admin` (`username`, `password`) 
            VALUES ('$username', '$password')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        header("Location: ../login/login");
        exit();
    } else {
        echo "Database Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Secure Sign-Up</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../login/style.css">

  <style>
    .error-message {
      color: red;
      font-size: 14px;
      margin-top: 5px;
    }
  </style>
</head>

<body>
  <div class="container">
    <form class="main-form" method="POST" onsubmit="return validateForm()">
      <div class="left">
        <h1>Hello, Welcome!</h1>
        <img src="../assets/img/Ikanhousing-logo-ng-1.svg" alt="Logo">
      </div>
      <div class="right">
        <h1>Sign Up</h1>

        <div class="form-group">
          <i class="fa fa-user"></i>
          <input type="text" placeholder="Username" name="username" required>
        </div>

        <div class="form-group">
          <i class="fa fa-lock"></i>
          <input type="password" placeholder="Password" name="password" id="password" required>
        </div>

        <div class="form-group">
          <i class="fa fa-lock"></i>
          <input type="password" name="confirm_password" placeholder="Confirm Password" id="confirm_password" required>
          <div id="password-error" class="error-message"></div>
        </div>
        <button type="submit">Sign Up</button>
      </div>
    </form>
  </div>

  <script>
    function validateForm() {
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm_password').value;
      const errorBox = document.getElementById('password-error');

      if (password !== confirmPassword) {
        errorBox.textContent = "Passwords do not match!";
        return false; // Prevent form submit
      } else {
        errorBox.textContent = ""; // Clear error
        return true; // Allow form submit
      }
    }
  </script>
</body>

</html>
