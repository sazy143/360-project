<!DOCTYPE html>
<html>
<head>
    <title>Edit Products</title>
</head>
<body>
    <h1>Edit Product Info</h1>
    <h3>(Leave fields blank if you would not like them to change)</h3>
    <form method="post" action="updateprod.php" enctype="multipart/form-data">
        Product Name: 
        <select name="product" id="prod">

            <?php
            include 'connection.php';
            $error = mysqli_connect_error();
            if($error != null){
                $output = "<p>Unable to connect to database!</p>";
                exit($output);
            }else{
                $sql = mysqli_query($connection,"SELECT name, prodID FROM Products");
                while($row = $sql->fetch_assoc()){
                    echo "<option value=".$row['prodID'].">" . $row['name'] . "</option>";
                }
            }
            ?>
            <option value="idk">test</option>
        </select>
        <br>
        description
        <input type="text" name="description" placeholder="description">
        <br>
        price
        <input type="number" name="price" placeholder="price">
        <br>
        image
        <input type="file" name="image">
        <p>Max file size 1mb</p>
        <p>Allowed image types are jpg, jpeg, gif, png</p>
        category
        <select name="category">
            <option value=""></option>
            <?php 
                $sql1 = mysqli_query($connection,"SELECT catName FROM ProductCategory");
                while($row = $sql1->fetch_assoc()){
                    echo "<option value=".$row['catName'].">" . $row['catName'] . "</option>";
                }
            ?>
        </select>
        <br>
        <input type="submit" value="Update" name="submit">
        <input type="submit" value="Delete Product" name="delete" class="delete" >
    </form>
    
</body>
</html>