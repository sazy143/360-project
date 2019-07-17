<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/admin.css"/>
    <link rel="stylesheet" href="../css/common.css"/>

  </head>

  <body>
<?php
      include 'header.php';
      session_start();
      if(!(isset($_SESSION['isAdmin']))||$_SESSION['isAdmin']!=1){
          header("Location: home.php");
      }
      ?>
    <main>
        <h1>Admin Portal</h1>
        
        <table id="adminfeature">
            <tr>
                <td id="feature1"><a href="editProduct.php">Edit/Delete Product</a></td>
                <td id="feature2"><a href="addProduct.php">Add a Product</a></td>
                <td id="feature3"><a href="searchUser.php">Search User</a></td>
            </tr>
            <tr>
                <td id="feature4">feature coming soon</td>
                <td id="feature5">feature coming soon</td>
                <td id="feature6">feature coming soon</td>
            </tr>
        </table>
        
        
    </main>
      
      <?php
      include 'footer.php';
      ?>
  </body>

</html>