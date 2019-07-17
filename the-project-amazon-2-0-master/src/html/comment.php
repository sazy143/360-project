<!DOCTYPE html>
<html>
<head>
    <title>Comments</title>
    <link rel="stylesheet" href="../css/search.css">
</head>
<body>
    <?php
    session_start();
    include 'header.php';
    ?>
    <main>
        <div id="results">
    <?php
        if(!isset($_GET['id'])||$_SERVER['REQUEST_METHOD']!="GET"||$_GET['id']==""){
            header("Location: home.php");
        }else{
            $sql = "SELECT * FROM Review WHERE userID = ? ORDER BY revDate DESC";
            $stmt = $connection -> prepare($sql);
            $stmt -> bind_param("i",$_GET['id']);
            $stmt ->execute();
            $stmt ->bind_result($revID,$description,$rating,$revDate,$userID,$prodID);
            $numrows=0;
            if(isset($_SESSION['isAdmin'])&&$_SESSION['isAdmin']==1){
                echo "<table><tr><td>Delete Comment</td><td>Review Date</td><td>Description</td><td>Product ID</td></tr>";
                while($stmt->fetch()){
                    echo "<tr id=".$revID."><td class='del'>X</td><td>".$revDate."</td><td>".$description."</td><td><a class='idk' href=\"productInfo.php?id=".$prodID."\">".$prodID."</a></td></tr>";
                    $numrows++;
                }
                echo "</table>";
            }else{
                
                echo "<table><tr><td>Review Date</td><td>Description</td><td>Product ID</td></tr>";
                while($stmt->fetch()){
                    echo "<tr><td>".$revDate."</td><td>".$description."</td><td><a class='idk' href=\"productInfo.php?id=".$prodID."\">".$prodID."</a></td></tr>";
                    $numrows++;
                }
                echo "</table>";
            }
            if($numrows==0){
                echo "<p>User has not made any comments</p>";
            }
        }
        
    ?>
        </div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(function(){
          $(".del").on("click",function(){
            var user = <?php echo $userID; ?>;
            var value = $(this).parent().attr('id');
              console.log(user);
            $.post('../php/delcom.php',{value:value,user:user},function(data){
                
                $("#results").html(data);
                
            });
            return false;
        });
          });
        console.log("finish");
        </script>
    
    </main>
    <?php
    include 'footer.php';
    ?>
    
</body>


</html>