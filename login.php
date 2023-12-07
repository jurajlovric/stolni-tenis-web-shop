<?php
session_start();
error_reporting(0);
include("connection.php"); 
$loginFailed = false;

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($conn, "select id from user where username='$username' AND password='$password' ");
    $ret = mysqli_fetch_array($query);
    if ($ret > 0) {
        $_SESSION['id'] = $ret['id'];
        header('location: index.php');

    } else { 
        $loginFailed = true;
    }
}

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = mysqli_query($conn, 'select id from user where username="' . $username . '"');
    $ret = mysqli_fetch_array($query);
    if ($ret > 0) {
        $usernameTaken = true;
    } else {
        $query = mysqli_query($conn, 'insert into user (email, username, password) values 
        ("' . $email . '", "' . $username . '", "' . $password . '")');
        $query2 = mysqli_query($conn, 'select id from user where username="' . $username . '"');
        if ($query) {
            $ret = mysqli_fetch_array($query2);
            $_SESSION['id'] = $ret['id'];
            header('location: index.php');
        } else {
            echo '<script>alert("Greška kod registracije")</script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- navbar -->
    <div class="container">
        <div class="navbar">
            <div>
                <a href="index.php"><img src="img/logo.png" class="logo" width="125px"></a>
            </div>
            <nav>
                <ul id="MenuItems">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="kupovina.php">Kupovina</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
            <a href="cart.php"><img src="img/kosara.png" width="30px" height="30px"></a>
            <img src="img/menu.png" class="menu-icon" onclick="menutoggle()">
        </div>
    </div>

    <!-- login -->
    <div class="login">
        <div class="container">
            <div class="row">
                <div class="col-2">
                    <img src="img/home.png" width="100%">
                </div>
                <div class="col-2">
                    <div class="form-container">
                        <div class="form-btn">
                            <span onclick="login()">Login</span>
                            <span onclick="register()">Register</span>
                            <hr id="indicator">
                        </div>

                        <form id="LoginForm" method="post" action="login.php">
                            <input type="username" placeholder="Username" name="username">
                            <input type="password" placeholder="Password" name="password">
                            <button type="submit" class="btn" name="login">Login</button>
                        </form>

                        <form id="RegForm" method="post" action="#">
                            <input type="text" placeholder="Username" name="username">
                            <input type="email" placeholder="Email" name="email">
                            <input type="password" placeholder="Password" name="password">
                            <button type="submit" class="btn" name="register">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="footer-col-1">
                    <h3>Kontakt osoba: julovric@gmail.com</h3>
                </div>
                <div class="footer-col-2">
                    <img src="img/logo.png">
                    <p>Osiguravam najbolju kvalitetu</p>
                </div>
                <div class="footer-col-3">
                    <h3>Želim vam sigurnu kupovinu</h3>
                </div>
            </div>
        </div>
    </div>


    <script src="login.js"></script>
    <script src="menu.js"></script>
</body>
</html>