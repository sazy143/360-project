<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
  if(isset($_POST["fName"])
    &&isset($_POST['lName'])
    &&isset($_POST['uName'])
    &&isset($_POST['e'])){
    
    include_once("connection.php");
      
    session_start();
    $userName = $_SESSION['username'];
    
    $first = $_POST["fName"];
    $last = $_POST['lName'];
    $user = $_POST['uName'];
    $email = $_POST['e'];
    
              
    $stmt = $connection->prepare("UPDATE User SET firstName = ?, 
                                  lastName = ?, 
                                  userName = ?,
                                  email = ?
                                  WHERE userName = ?;");
    $stmt->bind_param("sssss",$first,$last,$user,$email,$userName);
    $stmt->execute();
 
    mysqli_close($connection);
  }
} 
?>