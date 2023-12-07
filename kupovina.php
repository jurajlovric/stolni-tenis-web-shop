<?php
session_start();
error_reporting(0);
include("connection.php"); 

$sql = "SELECT * FROM item";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kupovina</title>
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
    </div>

    <!-- naslov i dropdown -->
    <div class="small-container">
        <div class="row row-2">
            <h2 class="title">Svi proizvodi</h2>
        </div>

        <!-- proizvodi -->
        <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imageString=$row['image'];
                    $imageArray = explode(',', $imageString);
                    $firstImage = $imageArray[0];
                    echo '<a href="item.php?id=' . $row['id'] . '">';
                    echo '<article class="row">';
                    echo '<img class="col-4" src=' . $firstImage. '>';
                    echo '<div class="">';
                    echo '<h1 class="item-title">'.$row['ime'].'</h1>';
                    echo '<div class="price"><h1>'.$row['cijena'].'&euro;</h1></div>';
                    echo '</div>';
                    echo '</article>';
                    echo '</a>';
                
                }
            } else {
                echo '<h1 class="tshirt-title">Nema proizvoda</h1>';
            }
            $conn->close();
            ?>
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
    <script src="kupovina.js"></script>
</body>
</html>