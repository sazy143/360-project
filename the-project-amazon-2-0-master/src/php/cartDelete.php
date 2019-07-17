<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(isset($_POST["prodID"])
    &&isset($_POST["userID"])){
    
   
    $prodID = $_POST['prodID'];
  
    
    include_once("connection.php");
        
              session_start();
              $userName = $_SESSION['username'];
              
              $stmt = $connection->prepare("SELECT userID FROM User WHERE userName = ?");
              $stmt->bind_param("s",$userName);
              $stmt->execute();
              $stmt->bind_result($uID);
              $stmt->fetch();
              
              $userID = $uID;
    
    $sql = $connection->prepare("DELETE FROM Cart WHERE userID = ? AND prodID = ?");
    $sql->bind_param("ii" , $userID, $prodID);
    $sql->execute();
    
    mysqli_close($connection);
  }
} 
?>