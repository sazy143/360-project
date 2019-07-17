<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['username'])){
    header ("Location: ../html/login.php");
}else{
    session_unset();
    session_destroy();
    header("Location: ../html/home.php");
}