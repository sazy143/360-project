<!DOCTYPE html>
<html>

<?php
include "connection.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if(isset($_POST['email'])){
            $sql = "SELECT * FROM User WHERE email = '".$_POST['email']."'";

            $results = mysqli_query($connection, $sql);

            if(mysqli_num_rows($results)>0){
                $user = $results->fetch_assoc();
                $exists = true;
                echo $exists;
            }
            else{
                $exists = false;
                echo $exists;
            }
    }
}
    mysqli_close($connection);

?>
</html>
