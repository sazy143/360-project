<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['isAdmin'])||$_SERVER['REQUEST_METHOD']!="POST"){
    echo "break";
    exit();
}
?>
<html>
<?php
include '../php/connection.php';
if(strpos($_POST['val'],"0")!==false){
    $stmt = $connection -> prepare("UPDATE User SET isBanned = 1 WHERE username = ?");
    $stmt -> bind_param("s",$_POST['user']);
    $stmt-> execute();
    echo "1";
}else{
    $stmt = $connection -> prepare("UPDATE User SET isBanned =0 WHERE username = ?");
    $stmt -> bind_param("s",$_POST['user']);
    $stmt -> execute();
    echo "0";
}
?>

      </html>