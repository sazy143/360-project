<!DOCTYPE html>
<html>

<?php
include '../php/connection.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['password']) & isset($_POST['email'])){
                $sql = "UPDATE User SET password ='".md5($_POST['password'])."' WHERE email='".$_POST['email']."'";
                $results = mysqli_query($connection, $sql);
                echo $results;
            }
    }
    mysqli_close($connection);

?>