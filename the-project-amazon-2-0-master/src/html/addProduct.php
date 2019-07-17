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
    <h1>Add a Product!</h1>
    <form id="edit" method="post" action="../php/addProduct.php" enctype="multipart/form-data">
        <div class="grid-cont">
        <label class="grid-iteml">Product Name:</label>
        <input class="grid-item" type="text" name="name" placeholder="Product" required>
        <label class="grid-iteml">Description:</label>
        <input class="grid-item" type="text" name="description" placeholder="Description">
        <label class="grid-iteml">Price:</label>
        <input class="grid-item" type="number" name="price" placeholder="Price" required>
        <label class="grid-iteml">Image:</label>
        <input class="grid-item" type="file" name="image" required>
        <p id="spec" class="grid-iteml">Max file size 1mb <br>
        Allowed image types are jpg, jpeg, gif, png</p>
        
        <label class="grid-iteml">Category:</label>
        <select class="grid-item" name="category" required>
            <?php 
                $sql1 = mysqli_query($connection,"SELECT catName FROM ProductCategory");
                while($row = $sql1->fetch_assoc()){
                    echo "<option value=".$row['catName'].">" . $row['catName'] . "</option>";
                }
            ?>
        </select>
        </div>
        <br>
        <input class="center" type="submit" value="Insert" name="submit">
    </form>
    
</main>
    <?php
        include 'footer.php';
    ?>
</body>
</html>