
<?php
print_r($_GET);
include 'connection.php';
$sql = mysqli_query($connection,"SELECT * FROM Products");
    while($row = $sql->fetch_assoc()){
        $image = $row['image'];
        echo 
            "<div class='item'>
                <figure>
                    <img src='data:image/".$row['contentType'].";base64,".base64_encode($row['image'])."' alt='".$row['name']." picture' width='200' height='200'/>
                </figure>
                <div>
                    <a href='productInfo.php?id=".$row['prodID']."'><h2 class='itemTitle'>".$row['name']."</h2></a>
                    <h3 class='price'>$".$row['price']."</h3>
                    <p>".$row['description']."</p>
                </div>
            </div>
            ";
        
    }
?>