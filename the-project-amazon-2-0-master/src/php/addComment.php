<!DOCTYPE html>
<html>

<?php

session_start();

include "connection.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['comment']) & isset($_POST['prodID'])){
            $sql = "SELECT userID FROM User WHERE username = '".$_SESSION['username']."'";
            $results = mysqli_query($connection, $sql);
            $user = $results -> fetch_assoc();
            $userID = $user['userID'];
            $date = getdate();
            $revdate = $date['year']."-".$date['mon']."-".$date['mday'];

            $sql = "INSERT INTO Review (userID, description, prodID, revDate) VALUES ('".$userID."','".$_POST['comment']."','".$_POST['prodID']."','".$revdate."')";
            $response = mysqli_query($connection, $sql);
            echo $response;
    }
}
    mysqli_close($connection);

?>
</html>
