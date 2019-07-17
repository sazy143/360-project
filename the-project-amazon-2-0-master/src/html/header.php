<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/header.css" />

</head>
<body>
<?php
    session_start();
    include "../php/connection.php";
    ?>
<header>
    
    <a href="home.php"><i id="home" class="material-icons md-36">home</i></a>
    <?php
    if(!isset($_SESSION['username'])||$_SESSION['username']==""||$_SESSION['username']==null){
        echo '<a href="login.php"><i id="login">Login</i></a>';
    }else{
        echo '<a href="logout.php"><i id="login">Logout</i></a>';
    }
    if(isset($_SESSION['isAdmin'])&&$_SESSION['isAdmin']==1){
        echo '<a href="adminPortal.php"><i id="admin">Admin</i></a>';
    }
    ?>
    <a href="cart.php"><i id="cart" class="material-icons md-36">shopping_cart</i></a>
    <a href="account.php"><i id="account" class="material-icons md-36">account_box</i></a>
    <form method="get" action="product.php">
    <input type="submit" id="search" class="material-icons md-36" value="search">
    <input id="searchbox" name="search" type="text" />
    </form>
</header>
    </body>
</html>