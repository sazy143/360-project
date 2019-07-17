<!DOCTYPE html>
<html>

<?php

session_start();

include "connection.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['username']) & isset($_POST['password'])){
            $sql = "SELECT * FROM User WHERE username = '".$_POST['username']."' AND password = '".md5($_POST['password'])."'";

            $results = mysqli_query($connection, $sql);
            $wack = $results;
            if(mysqli_num_rows($results)>0){
                $user = $wack->fetch_assoc();
                if($user['isBanned']==false){
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['isAdmin'] = $user['isAdmin'];
                    $login = true;
                }
                else{
                    $login = false;
                }
                echo $login;
            }
            else{
                $login = false;
                echo $login;
            }
    }
}
    mysqli_close($connection);

?>
</html>
