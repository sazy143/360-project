<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(isset($_POST["newPassword"])&& isset($_POST["oldPassword"])){
    
    
    $newPassword = $_POST['newPassword'];
    $oldPassword = $_POST['oldPassword'];
    $newPass = md5($newPassword);
    $oldPass = md5($oldPassword);
    
    include "connection.php";
      
    session_start();
    $userName = $_SESSION['username'];
    
    $stmt = $connection->prepare("SELECT password FROM User WHERE userName = ?");
    $stmt->bind_param("s",$userName);
    $stmt->execute();
    $stmt->bind_result($password);
    $stmt->fetch();
    $p = $password;
    $stmt->close();
    
    $response = "a";
    echo $response;
    if($oldPass == $p){          
    $stmt = $connection->prepare("UPDATE User SET password = ? WHERE userName = ?");
    $stmt->bind_param("ss",$newPass,$userName);
    $stmt->execute();
    $stmt->close();
      }
    }
  }
 
?>