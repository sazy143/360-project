<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(isset($_POST["prodID"])
    &&isset($_POST["newAmount"])){
    
    include_once("connection.php");
    
     
              session_start();
              $userName = $_SESSION['username'];
              
              $stmt = $connection->prepare("SELECT userID FROM User WHERE userName = ?");
              $stmt->bind_param("s",$userName);
              $stmt->execute();
              $stmt->bind_result($userID);
              $stmt->fetch());
              
              
    
    $uID = $userID;
    $prodID = $_POST['prodID'];
    $newAmount = $_POST['newAmount'];
    
    
    
    $sql = $connection->prepare("UPDATE Cart SET amount = ? WHERE userID = ? AND prodID = ?");
    $sql->bind_param("iii" , $newAmount , $uID, $prodID);
    $sql->execute();
    
    mysqli_close($connection);
  }
} 
?>