<?php
session_start();
error_reporting(0);
include("connection.php");

$user_id = $_SESSION['id'];

$query = mysqli_query($conn, 'SELECT username FROM user WHERE id = "'.$user_id.'"');

if(strlen($_SESSION['id']) != 0){
    $loggedIn = true;
}
else {
    $loggedIn = false;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    session_start();
    error_reporting(0);

    $sql = "SELECT * FROM item WHERE id = $id";
    $result = $conn->query($sql);
    if($result->num_rows) {
        $row = $result->fetch_assoc();
        $price = $row['cijena'];
        $item_id = $id;
    }
    else {
        header('location: index.php');
    }
}
if(isset($_POST['add-to-cart'])) {
    $query = mysqli_query($conn, 'select * from cart where user_id = '. $user_id . ' and is_paid = 0');
    $ret = mysqli_fetch_array($query);
    if($ret == 0){
        $query = mysqli_query($conn, 'insert into cart (user_id, cost) values ("' . $user_id . '","'. $price .'")');
        $query = mysqli_query($conn, 'select id from cart where user_id = '. $user_id . ' and is_paid = 0');
        $ret = mysqli_fetch_array($query);
        $cart_id = $ret[0];


        $query = mysqli_query($conn, 'insert into cart_item (cart_id, item_id) values
        ("' . $cart_id . '","'. $item_id .'")');
        
        
    
    }
    else {
        $query = mysqli_query($conn, 'select cost from cart where user_id = '. $user_id . ' and is_paid = 0');
        $ret = mysqli_fetch_array($query);
        $cost = $ret[0] + $price;

        $query = mysqli_query($conn, 'update cart set cost = '. $cost .' where user_id = '. $user_id . ' and is_paid = 0');
        $query = mysqli_query($conn, 'select id from cart where user_id = '. $user_id . ' and is_paid = 0');
        $ret = mysqli_fetch_array($query);
        $cart_id = $ret[0];
        $query = mysqli_query($conn, 'insert into cart_item (cart_id, item_id) values
        ("' . $cart_id . '","'. $item_id .'")');
        
    }
    
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- navbar -->
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

    <!-- item detalji -->
    <div class="small-container single-item">
        <div class="row">
        <?php 
                    if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $sql = "SELECT * FROM item WHERE id = $id";
                        $result = $conn->query($sql);
                            if($result->num_rows) {
                                $row = $result->fetch_assoc();
                                echo '<img src="'.$row['image'].'" alt="" id="front-image">';
                            }
                    }
        ?>
        </div>
    </div>

    </div>
    <div class="tshirt-info">
        <div class="name-price-container">
            <?php
            echo '<h1 id="tshirt-name">'.$row['name'].'</h1>';
            echo '<h1 id="price">'.$row['cijena'].'&euro;</h1>';
            ?>
        </div>

    <form class="form-input" name="add-to-cart-form" method="post" action="#">
        <?php 
        if(!$loggedIn){
            echo '<p>Log in to add to cart.</p>';
        }
        else {
            echo '<input type="submit" name="add-to-cart" value="DODAJ U KOŠARICU" class="">';
        }
        ?>
    </form>
    

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
    <script src="item.js"></script>
</body>
</html>