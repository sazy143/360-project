<!DOCTYPE html>
<html>
<head>
    <title>Edit Products</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <?php
        include 'header.php';
    if(!(isset($_SESSION['isAdmin']))||$_SESSION['isAdmin']!=1){
          header("Location: home.php");
      }
    ?>
<main>
    <h1>Edit Product Info</h1>
    <h3>(Leave fields blank if you would not like them to change)</h3>
    <form id="edit" method="post" action="updateprod.php" enctype="multipart/form-data">
        <div class="grid-cont">
        <label class="grid-iteml">Product Name:</label>
        <select class="grid-item" name="product" id="prod">

            <?php
            include '../php/connection.php';
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
        <label class="grid-iteml">Description:</label>
        <input class="grid-item" type="text" name="description" placeholder="Description">
        <label class="grid-iteml">Price:</label>
        <input class="grid-item" type="number" name="price" placeholder="Price">
        <label class="grid-iteml">Image:</label>
        <input class="grid-item" type="file" name="image">
        <p id="spec" class="grid-iteml">Max file size 1mb <br>
        Allowed image types are jpg, jpeg, gif, png</p>
        
        <label class="grid-iteml">Category:</label>
        <select class="grid-item" name="category">
            <option value=""></option>
            <?php 
                $sql1 = mysqli_query($connection,"SELECT catName FROM ProductCategory");
                while($row = $sql1->fetch_assoc()){
                    echo "<option value=".$row['catName'].">" . $row['catName'] . "</option>";
                }
            ?>
        </select>
        </div>
        <br>
        <input class="center" type="submit" value="Update" name="submit">
        <input class="center" type="submit" value="Delete Product" name="delete" class="delete" >
    </form>
    
</main>
    <?php
        include 'footer.php';
    ?>
</body>
</html>