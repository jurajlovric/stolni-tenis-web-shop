<?php
session_start();
error_reporting(0);
include("connection.php"); 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trgovina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- header -->
    <div class="header">
        <div class="container">
            <div class="navbar">
                <div>
                    <a href="index.php"><img src="img/logo.png" class="logo" width="125px"></a>
                </div>
                <nav>
                    <ul id="MenuItems">
                        <?php
                        $user_id = $_SESSION['id'];
                        $query = mysqli_query($conn, 'SELECT username FROM user WHERE id = "'.$user_id.'"');
                        $row = mysqli_fetch_array($query);
                        if(strlen($_SESSION['id']) != 0){
                            echo '<li><a href="index.php">Home</a></li>';
                            echo '<li><a href="kupovina.php">Kupovina</a></li>';
                            echo '<li>'.$row['username'].'</li>';
                            echo '<li><a href="logout.php">Odjava</a></li>';
                        }else{
                            echo '<li><a href="index.php">Home</a></li>';
                            echo '<li><a href="kupovina.php">Kupovina</a></li>';
                            echo '<li><a href="login.php">Login</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
                <a href="cart.php"><img src="img/kosara.png" width="30px" height="30px"></a>
                <img src="img/menu.png" class="menu-icon" onclick="menutoggle()">
            </div>
            <div class="row">
                <div class="col-2">
                    <h1>Nove gume i reketi!</h1>
                    <p>Kupite jeftino, a kvalitetno.</p>
                    <a href="kupovina.php" class="btn">Kupovina</a>
                </div>
                <div class="col-2">
                    <img src="img/home.png">
                </div>
            </div>
        </div>
    </div>

    <!-- brands -->
    <div class="brands">
        <div class="small-container">
            <div class="row">
                <div class="col-5">
                    <img src="img/butterfly.png">
                </div>
                <div class="col-5">
                    <img src="img/dhs.jpg">
                </div>
                <div class="col-5">
                    <img src="img/joola.png">
                </div>
                <div class="col-5">
                    <img src="img/tibhar.jpg">
                </div>
                <div class="col-5">
                    <img src="img/yasaka.jpg">
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

    <script src="menu.js"></script>
</body>
</html>