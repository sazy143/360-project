<!DOCTYPE html>
<html>

<?php

session_start();

include "connection.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['prodID']) & isset($_POST['quantity']) & isset($_POST['price']) & isset($_POST['userID'])){
        
            $sql = "INSERT INTO Cart (prodID, amount, price, userID) VALUES('".$_POST['prodID']."', '".$_POST['quantity']."', '".$_POST['price']."', '".$_POST['userID']."')";

            $results = mysqli_query($connection, $sql);
            echo $results;
    }
}
    mysqli_close($connection);

?>
</html>