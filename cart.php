<?php
session_start();
error_reporting(0);
include("connection.php"); 

$cost = 0;

$query = mysqli_query($conn, 'SELECT username FROM user WHERE id = "'.$user_id.'"');

if(strlen($_SESSION['id']) != 0){
    $loggedIn = true;
    $user_id = $_SESSION['id'];
}
else {
    $loggedIn = false;
}

if(isset($_POST['pay-now'])){
    $query = mysqli_query($conn, 'update cart set is_paid = 1 where user_id = '.$user_id.' and is_paid = 0');
}

if(isset($_POST['remove-item'])){
    $cart_item_id = $_POST['cart-item-id'];
    $price = $_POST['cart-item-cijena'];

    $query = mysqli_query($conn, 'delete from cart_item where id = '.$cart_item_id);

    $query = mysqli_query($conn, 'select cost from cart where user_id = '.$user_id.' and is_paid = 0');
    $ret = mysqli_fetch_array($query);
    $new_cost = $ret[0];
    $new_cost = $new_cost - $price;
    
    if($new_cost!=0){
        $query = mysqli_query($conn, 'update cart set cost = '.$new_cost.' where user_id = '.$user_id.' and is_paid = 0');
    }
    else {
        $query = mysqli_query($conn, 'delete from cart where user_id = '.$user_id.' and is_paid = 0');
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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

    <!-- cart -->
    <div class="">
        <div class="">
            <div class="">
                <?php
                    if($loggedIn){
                        $query = mysqli_query($conn, 'select id, cost from cart where user_id = '. $user_id . ' and is_paid = 0');
                        if($query){
                            $ret = mysqli_fetch_array($query);
                            if($ret){
                                $cart_id = $ret[0];
                                $cost = $ret[1];
                                $query = 'select * from cart_item where cart_id = '. $cart_id;
                                $result = $conn->query($query);

                                if($result->num_rows > 0){
                                    while ($row = $result->fetch_assoc()) {
                                        $cart_item_id = $row['id'];
                                        $item_id = $row['item_id'];
        
                                        $query = mysqli_query($conn, 'select * from item where id = '. $item_id);
                                        $ret = mysqli_fetch_array($query);
                                        $name = $ret[1];
                                        $price = $ret[2];
                                        $imageString=$ret[3];
                                        $imageArray = explode(',', $imageString);
                                        $firstImage = $imageArray[0];
                                        
                                        echo '<article class="">';
                                        echo '<div class="">';
                                        echo '<img src="'. $firstImage .'" class="" alt="">';
                                        echo '<div class="">';
                                        echo '<h1 class="">'. $name .'</h1>';
                                        echo '<h1 class="">'. $price .'&euro;</h1>';
                                        echo '</div>';
                                        echo '</div>';
                                        echo '<form name="remove-item-form" class="cart-form" method="post">';
                                        echo '<input type="hidden" name="cart-item-cijena" value="'.$price.'"/>';
                                        echo '<input type="hidden" name="cart-item-id" value="'.$cart_item_id.'"/>';
                                        echo '<input type="submit" name="remove-item" value="&#10005;" id="close-btn-item"/>';
                                        echo '</form>';
                                        echo '</article>';
                                    } 
                                }
                            }
                        }
                        else {
                            $cost = 0;
                        }
                        
                        
                        
                    }
                    else {
                        echo '<article class="">';
                        echo '<div class="">';
                        echo '<div class="">';
                        echo '<h1 class="">Log in to acces the cart.</h1>';
                        echo '</div>';
                        echo '</article>';
                    }
                
                
                ?>
            
            <?php 
                if($loggedIn) {
                    
                    if($cost != 0){
                        echo '<div class="">';
                        echo '<div class="">';
                        echo '<h1 class="">Total cost:</h1>';
                        echo '<h1 class="" id="cijena-total">'.$cost.'&euro;</h1>';
                        echo '</div>';
                        echo '<form name="pay-now-form" class="cart-form" method="post">';
                        echo '<input type="submit" value="PAY NOW" name="pay-now" class="add-to-cart-btn">';
                        echo '</form>';
                        echo '</div>';
                    }
                    else {
                        echo '<article class="">';
                        echo '<div class="">';
                        echo '<div class="">';
                        echo '<h1 class="">Your cart is empty.</h1>';
                        echo '</div>';
                        echo '</article>';
                    }
                }
            
            ?>
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

    <<script src="menu.js"></script>
</body>
</html>