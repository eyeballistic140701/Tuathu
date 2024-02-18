<?php
require_once 'vendor/autoload.php';
session_start();
// include('dbconnection.php');
// $conn = dbconnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_or_email = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username_or_email) || empty($password)) {
        $_SESSION['login_error'] = "Both fields are required!";
        header('location: login.php');
        exit();
    }

    $sql = "SELECT password FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username_or_email, $username_or_email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $stmt->close();
    $conn->close();

    if ($row && password_verify($password, $row['password'])) {
        header('location: /home');
    } else {
        $_SESSION['login_error'] = "Incorrect username/email and password";
        header('location: login.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tuathu.co</title>
    <!-- External CSS/JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">

    <!-- import the webpage's stylesheet -->
    <link rel="stylesheet" href="login.css">
    
</head>

<body>
    <nav>
      <!-- Logo -->
      <div class="logo">
        <a href="/index">
          <img
            src="https://cdn.glitch.global/5773f9b4-d396-42cf-b854-a0ccb2ceaa1c/MagicEraser_240218_141113.png?v=1708266293514"
            alt="Logo"
          />
        </a>
      </div>
      <div class="openMenu"><i>☰</i></div>
      <ul class="mainMenu">
        <li><a href="index">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <div class="closeMenu"><i class="fa fa-times"></i></div>
        <span class="icons">
          <i class="fab fa-twitter"></i>
          <i class="fab fa-instagram"></i>
          <i class="fab fa-discord"></i>
          <i class="fab fa-github"></i>
        </span>
      </ul>
    </nav>
    
    <div class="form-container">
        <h2>Login</h2>
        <div class="form-inputs">
            <form action="login.php" method="post">
                <div>
                    <input type="text" id="uname_or_email" name="username" placeholder="Username or Email" title="Enter a valid email">
                </div>
                <div>
                    <input type="password" id="login_password" name="password" placeholder="Password" required maxlength="26" title="Password should be at least 6 characters long">
                </div>
                <div>
                    <input type="submit" value="Login">
                </div>
            </form>
            <a href="/register" class="register-btn">Register</a>
        </div>
    </div>

    <script>
        const mainMenu = document.querySelector('.mainMenu');
        const closeMenu = document.querySelector('.closeMenu');
        const openMenu = document.querySelector('.openMenu');

        openMenu.addEventListener('click', () => {
            mainMenu.style.display = 'flex';
            mainMenu.style.top = '0';
        });

        closeMenu.addEventListener('click', () => {
            mainMenu.style.top = '-150vh';
        });
    </script>


</body>

</html>
