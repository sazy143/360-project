<?php

$first = $_POST['first'];
$last = $_POST['last'];
$add1 = $_POST['add1'];
$add2 = $_POST['add2'];
$city = $_POST['city'];
$country = $_POST['country'];
$province = $_POST['province'];
$postal = $_POST['postal'];



$placed = date("Y/m/d");

            include 'connection.php';
            
              session_start();
              $userName = $_SESSION['username'];
              
              $stmt = $connection->prepare("SELECT userID FROM User WHERE userName = ?");
              $stmt->bind_param("s",$userName);
              $stmt->execute();
              $stmt->bind_result($userID);
              $stmt->fetch();
              
              $uID = $userID;
              $stmt->close();

            $stmt = $connection->prepare("SELECT SUM(price*amount) FROM Cart WHERE userID = ? GROUP BY userID");

              $stmt->bind_param("i",$uID);
              $stmt->execute();
              $result = $stmt->bind_result($subTotal);
              $stmt->fetch();
              $cost = $subTotal;

              $stmt->close();

            $stmt = $connection->prepare("INSERT INTO Address(addy,city,province,country,postalCode)
                    VALUES(?,?,?,?,?);");
            
            $stmt->bind_param("sssss",$add1,$city,$province,$country,$postalCode); 
            $stmt->execute();
            $stmt->close();
            $last_id = mysqli_insert_id($connection);
                
            
            
            $stmt = $connection->prepare("INSERT INTO Orders(placed,cost,userID,addID)
                    VALUES (?,?,?,?)");
            
            $stmt->bind_param("sdii",$placed,$cost,$uID,$last_id);
            $stmt->execute();
            $stmt->close();
            $last_id = mysqli_insert_id($connection);

            $stmt ="SELECT prodID, amount, price FROM Cart WHERE userID = " . $uID . ";";
            $result = mysqli_query($connection, $stmt);
            $numItems = mysqli_num_rows($result);
         
            $orderID = $last_id;
            
 
                    
                    for($x = 0; $x < $numItems; $x++) {
                      $prod = $result->fetch_array(MYSQLI_ASSOC);
                         $sql = $connection->prepare("INSERT INTO OrderedProduct(prodID,orderID,amount,price)
                      VALUES(?,?,?,?);");
            
                      $sql->bind_param("iiid",$prod['prodID'],$orderID,$prod['amount'],$prod['price']);
                      $sql->execute();   
                      $sql->close();
                    }
             

                $sql = $connection->prepare("DELETE FROM Cart WHERE userID = ?");
                $sql->bind_param("i",$uID);
                $sql->execute();
                $sql->close();
                
                
             
            echo "<script>alert('Order placed');</script>";
            echo "<script>window.location.replace('../html/home.php');</script>";

            
?>