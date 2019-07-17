<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION['isAdmin'])||$_SERVER['REQUEST_METHOD']!="POST"){
    header("Location: ../html/home.php");
}
?>
<head>
<link rel="stylesheet" href="../css/search.css">
</head>
<html>
<?php
include '../php/connection.php';
$sql = "SELECT userID, firstName, lastName, username, email,isAdmin, isBanned, creationDate FROM User WHERE username like ?";
$stmt = $connection->prepare($sql);
$string = "%".$_POST['value']."%";
$stmt->bind_param("s",$string);
$stmt->execute();
$stmt -> bind_result($userID,$firstName,$lastName,$username,$email,$isAdmin,$isBanned,$creationDate);
echo "<table><tr><td>First Name</td><td>Last Name</td><td>Username</td><td>Email</td><td>Admin</td><td>Banned</td></tr>";
while($stmt->fetch()){
    echo "<tr>
    <td><a class='idk' href=\"comment.php?id=".$userID."\">".$firstName."</a></td><td>".$lastName."</td><td class='uname'>".$username."</td><td>".$email."</td><td>".$isAdmin."</td><td class='ban' title='click to ban or unban user'>".$isBanned."</td>

    </tr>
    ";
}
    echo "</table>";
?>
    <script>
        $(function(){
            $(".ban").on("click",function(){
                var val = $(this).html();
                var user = $(this).parent().find(".uname").html();
                console.log(val);
                console.log(user);
                var tdel = $(this);
                $.post("../php/banhammer.php",{val:val,user:user},function(data){
                    if(data.includes("break")){
                        window.location.replace("home.php");
                    }
                    $(tdel).html(data);
                });
                return false;
            });
        });
        
        
        </script>

      </html>