<!DOCTYPE html>
<html>

<?php
include '../php/connection.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['firstName']) & isset($_POST['lastName']) & isset($_POST['username']) & isset($_POST['password']) & isset($_POST['email']) & isset($_FILES['userImage'])){
            $sql = "SELECT * FROM User WHERE username = '".$_POST['username']."' OR email = '".$_POST['email']."'";

            $results = mysqli_query($connection, $sql);

            if(mysqli_num_rows($results)>0){
                echo "User already exists with this name and/or email";
                echo "<br><a href=\"../html/register.html\"> Return to user entry </a>";
            }
            else{
                $sql = "INSERT INTO User (firstName, lastName, username, password, email) VALUES ('".$_POST['firstName']."','".$_POST['lastName']."','".$_POST['username']."','".md5($_POST['password'])."','".$_POST['email']."')";
                $results = mysqli_query($connection, $sql);
                uploadImage($connection);
                $message = "An account for the user ".$_POST['username']." has been created";
                header("Location: ../html/login.php");
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
    }
}
    mysqli_close($connection);


function uploadImage($connection){
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($_FILES["userImage"]["name"],PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["userImage"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } 
    else {
        echo "File is not an image.";
        echo "<br><a href=\"../html/register.html\"> Return to user entry </a>";
        $uploadOk = 0;
        }

    if ($_FILES["userImage"]["size"] > 300000) {
        echo "Sorry, your file is too large.";
        echo "<br><a href=\"../html/register.html\"> Return to user entry </a>";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        echo "<br><a href=\"../html/register.html\"> Return to user entry </a>";
        $uploadOk = 0;
    }
   
    if ($uploadOk == 0) {
        echo "";

    } 
    else {
        insertImage($imageFileType, $connection);
    }
    return;
}

function insertImage($imageFileType, $connection){
    $imagedata = file_get_contents($_FILES['userImage']['tmp_name']);
    $sql = "UPDATE User SET image = ?, contentType = ? WHERE username = ?";
    $stmt = mysqli_stmt_init($connection);
    mysqli_stmt_prepare($stmt, $sql);
    $null = NULL;
    mysqli_stmt_bind_param($stmt, "bss", $null, $imageFileType, $_POST['username']);
    mysqli_stmt_send_long_data($stmt, 0, $imagedata);
    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return;
}
?>