<!DOCTYPE html>
<html>
<head>
    <title>home</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/home.css">
    <audio>
    <source src="../../images/chia.mp3">
    </audio>
</head>

    <body>
        
        <?php
            include 'header.php';
        ?>
        <div id="containter">
            <main>
        <div id="imgs">
            <a href="product.php"><img class="spin" id="img1" src="../../images/ears.jpg"></a>
            <a href="product.php"><img class="spin" id="img2" src="../../images/morty.jpg"></a>
            <a href="product.php"><img class="spin" id="img3" src="../../images/rick.jpg"></a>
        <script type="text/javascript">
            $(".spin").mouseenter(function(){
                $("<audio></audio>").attr({
                    'src': '../../images/chia.mp3',
                    'volume': 0.5,
                    'autoplay': 'autoplay'
                }).appendTo("body");
                //window.setTimeout(play, 4000);
            });
            
        </script>
        <div id="center">
        <a href="product.php"><button id="prod">View all Products</button></a>
        </div>
                </div>
        <div id="featured">
        <h2>Our most popular items</h2>
            
            <?php
                $sql = mysqli_query($connection,"SELECT p.* FROM OrderedProduct as o, Products as p WHERE p.prodID = o.prodID GROUP BY p.prodID ORDER BY amount DESC LIMIT 3");
                if(mysqli_num_rows($sql)<3){
                    echo "<p>Not enough Data</p>";
                }else{
                    $row = $sql -> fetch_assoc();
                    echo "
                        <div id='num1'>
                        <a href='productInfo.php?id=".$row['prodID']."'>
                        <figure>
                        <img src='data:image/".$row['contentType'].";base64,".base64_encode($row['image'])."' alt='".$row['name']." picture'/>
                    </figure>
                    <h2>".$row['name']."</h2>
                    <h5>$".$row['price']."</h5>
                    </a>
                        </div>
                    ";
                    $row = $sql -> fetch_assoc();
                    echo "
                        <div id='num2'>
                        <a href='productInfo.php?id=".$row['prodID']."'>
                        <figure>
                        <img src='data:image/".$row['contentType'].";base64,".base64_encode($row['image'])."' alt='".$row['name']." picture'/>
                    </figure>
                    <h2>".$row['name']."</h2>
                    <h5>$".$row['price']."</h5>
                    </a>
                        </div>
                    ";
                    $row = $sql -> fetch_assoc();
                    echo "
                        <div id='num3'>
                       <a href='productInfo.php?id=".$row['prodID']."'>
                        <figure>
                        <img src='data:image/".$row['contentType'].";base64,".base64_encode($row['image'])."' alt='".$row['name']." picture'/>
                    </figure>
                    <h2>".$row['name']."</h2>
                    <h5>$".$row['price']."</h5>
                    </a>
                        </div>
                    ";
                }
            ?>
            
       
        </div>
        
        
        <div id="bottom"></div>
            </main>
        
        </div>
    </body>
<?php
            include 'footer.php';
        ?>

</html>
