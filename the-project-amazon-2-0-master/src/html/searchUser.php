<!DOCTYPE html>
<html>
<head>
    <title>Show Users</title>
    <link rel="stylesheet" href="../css/search.css">
    </head>
<body>
    <?php
    include 'header.php';
    session_start();
    if(!isset($_SESSION['isAdmin'])||$_SESSION['isAdmin']!=1){
    header("Location: home.php");
    }
    ?>
    <main>
    <h1>Search For Username</h1>
    <form method="get" action="searchUser.php" id="searchform" autocomplete="off">
        <input id="sname" class="inb" type="text" placeholder="UserName">
        </form>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(function(){
          $("#searchform").on("input submit ready",function(){
            
            var value = $("#sname").val();
            $.post('../php/search.php',{value:value},function(data){
                
                $("#results").html(data);
                
            });
            return false;
        });
          });
      
        </script>
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
    <div id="results">
        <?php
include '../php/connection.php';
$sql = "SELECT userID, firstName, lastName, username, email,isAdmin, isBanned, creationDate FROM User WHERE username like ?";
$stmt = $connection->prepare($sql);
$string = "%";
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
        </div>
        
    </main>
    
    <?php
    include 'footer.php';
    ?>
    </body>




</html>