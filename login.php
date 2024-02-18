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
    <title>Atherium</title>
    <!-- External CSS/JS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            margin: 0;
            height: 100vh;
            background-color: #01171b;
            background-image: url("images/OIG11.jpeg");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            color: white;
        }

        .form-container {
            padding: 2rem;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            background: rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(4px) saturate(180%);
            -webkit-backdrop-filter: blur(4px) saturate(180%);
            border: 1px solid rgba(0, 0, 0, 0.125);

        }

        h2 {
            text-align: center;
            margin-bottom: 1rem;
        }

        label {
            margin-bottom: 1rem;
        }

        input[type="text"], input[type="email"], input[type="password"], input[type="submit"] {
            width: 100%;
            padding: 0.5rem;
            box-sizing: border-box;
            border: 1px solid #296889;
            border-radius: 5px;
            outline: none;
        }

        input[type="submit"] {
                cursor: pointer;
                background-color: gold;
                color: black;
        }

        input[type="submit"]:hover {
             background-color: goldenrod;
        }

        .register-btn {
            display: block;
            text-align: center;
            padding: 0.5rem;
            border: none;
            text-decoration: none;
            border-radius: 5px;
            background-color: black;
            color: white;
        }

        .register-btn:hover {
            background-color: grey;
        }

        .error-box {
            background-color: red;
            color: white;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 5px;
            text-align: center;
        }

        input.error {border: 2px solid red;}

        .form-inputs div {margin-bottom: 12px;}

        /*----------------------Navigation-----------------------*/
        nav {
          background-color: white;
            color: white;
            display: flex;
            justify-content: space-between;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100vw;
        }
        nav .logo img {
            width: 300px;
            padding: 20px;
            cursor: pointer;
            margin-bottom: 10px;
        }
        nav .mainMenu {
            display: flex;
            list-style: none;
            margin-right: 20px;
        }
        
        nav .mainMenu li a {
            display: inline-block;
            margin: 10px;
            padding: 10px;
            text-decoration: none;
            text-transform: uppercase;
            color: black;
        }
        nav .mainMenu li a:hover {
            border: 2px solid black;
            border-radius: 10px;
        }
        nav .openMenu {
            font-size: 2rem;
            margin: 20px;
            display: none;
            cursor: pointer;
          color: black;
        }
        nav .mainMenu .closeMenu, .icons i {
            font-size: 2rem;
            display: none;
            cursor: pointer;
        }
        .fa-twitter:hover{color: white;}
        .fa-github:hover {color: white;}
        .fa-discord:hover {color: white;}
        .fa-instagram:hover {color: white;}
        /*---------------Mobile Navigation------------------*/
        @media only screen and (max-width: 800px) {
            nav .mainMenu {
                position: fixed;
                height: 100vh;
                width: 100vw;
                z-index: 1050;
                display: none;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                transition: 0.6s ease;
                /*----Glass for mobile view----*/
                background: rgba(0, 0, 0, 0.75);
                backdrop-filter: blur(25px) saturate(180%);
                -webkit-backdrop-filter: blur(25px) saturate(180%);
                border: 1px solid rgba(0, 0, 0, 0.125);
                /*----------------------------*/
            }
            nav .mainMenu .closeMenu {
                display: block;
                position: absolute;
                top: 20px;
                right: 20px;
            }
            nav .openMenu {
                display: block;
            }
            nav .mainMenu li a:hover {
                background: none;
                color: white;
                font-size: 1.6rem;
            }
            .icons i {
                display: inline-block;
                padding: 12px;
            }
            nav .logo img {
                width: 300px;
                padding-top: 30px;
                cursor: pointer;
            }
        }
        /*-----------------End of Navigation---------------------*/
    </style>
</head>

<body>
    <nav>
      <!-- Logo -->
      <div class="logo">
        <a href="/index">
          <img
            src=""
            alt="Logo"
          />
        </a>
      </div>
      <div class="openMenu"><i>☰</i></div>
      <ul class="mainMenu">
        <li><a href="/index">Home</a></li>
        <li><a href="/login">Login</a></li>
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
