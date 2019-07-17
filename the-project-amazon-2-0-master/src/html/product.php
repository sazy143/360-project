<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/product.css" />
    
</head>

<body>
    <div id="container">
    <?php
    include 'header.php';
    ?>
    
<main>

<article id="left-sidebar">
    <i id="filters" class="material-icons md-36">settings</i>
    <h1>Filters</h1>
    <form method="get" action="product.php">
    <h2 class="category">Product Category</h2>
        <?php
        $cats = mysqli_query($connection,"SELECT * FROM ProductCategory");
        $count =0;
        while($row = $cats->fetch_assoc()){
            echo "<input type='checkbox' name='category".$count."' value=".$row['catName']."><label>".$row['catName']."</label><br>";
            $count +=1;
        }
        ?>
    <h2 class="filtprice">Price</h2>
        <input type="radio" name="filter1" value="range1"><label>$0.00-$10.00</label><br>
        <input type="radio" name="filter1" value="range2"><label>$10.01-$20.00</label><br>
        <input type="radio" name="filter1" value="range3"><label>$20.01-$30.00</label><br>
        <input type="radio" name="filter1" value="range4"><label>$30.01+</label>
        <br>
        <div class="butcenter">
        <input type="submit" class ="center" value="update">
        </div>
    </form>
</article>
    
<article id="center">

    <?php
    $categories = 0;
    $names = array();
    foreach($_GET as $key=>$item){
        if(strpos($key,'category')!==false){
            $categories +=1;
            $names[] =$item;
        }
    }
    $high = INF;
    $low = 0;
    if(isset($_GET['filter1'])){
        $range = $_GET['filter1'];
        switch($range){
            case "range1":
                $high=10.00;
                $low = 0;
                break;
            case "range2":
                $high = 20.00;
                $low = 10.01;
                break;
            case "range3":
                $high= 30.00;
                $low = 20.01;
                break;
            case "range4":
                $low= 30.01;
                $high = INF;
                break;
        }
    }
    $string = "SELECT Products.*,catName FROM Products, ProductCategory WHERE Products.catID = ProductCategory.catID";
    $bind = "";

    if(isset($_GET['search'])){
        $string = $string . " AND name LIKE ?";
        $bind= $bind ."%". $_GET['search']."%";
        
    }
    $string = $string . " ORDER BY Products.catID";
    $stmt = $connection ->prepare($string);
    if(isset($_GET['search'])){
    $stmt -> bind_param("s",$bind);
    }
    $stmt ->execute();
    $stmt ->bind_result($prodID,$name,$description,$price,$contentType,$image,$catID,$catname);
    $prodsfound = 0;
    while($stmt ->fetch()){
        
        if(in_array($catname,$names)&&$categories>0&&$price>=$low&&$price<=$high){
            $image1 = $image;
            echo 
                "<div class='item'>
                    <figure>
                        <img src='data:image/".$contentType.";base64,".base64_encode($image)."' alt='".$name." picture' width='200' height='200'/>
                    </figure>
                    <div>
                        <a href='productInfo.php?id=".$prodID."'><h2 class='itemTitle'>".$name."</h2></a>
                        <h3 class='price'>$".$price."</h3>
                        <p>".$description."</p>
                    </div>
                </div>
                ";
            $prodsfound+=1;
        }else if($price>=$low&&$price<=$high&&$categories==0){
        $image1 = $image;
        echo 
            "<div class='item'>
                <figure>
                    <img src='data:image/".$contentType.";base64,".base64_encode($image)."' alt='".$name." picture' width='200' height='200'/>
                </figure>
                <div>
                    <a href='productInfo.php?id=".$prodID."'><h2 class='itemTitle'>".$name."</h2></a>
                    <h3 class='price'>$".$price."</h3>
                    <p>".$description."</p>
                </div>
            </div>
            ";
        $prodsfound+=1;
    }
    }
    if($prodsfound==0){
        echo "<p>No products were found with these filters</p>";
    }
    
    ?>
</article>
</main>

    <?php
    include 'footer.php';
    ?> 
        </div>
</body>
   
    
</html>