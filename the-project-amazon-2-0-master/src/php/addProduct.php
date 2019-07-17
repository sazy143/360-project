<!DOCTYPE html>

<?php

if($_SERVER['REQUEST_METHOD']!="POST"){
    header("Location: ../html/addProduct.php");
    exit();
}
session_start();
if(!(isset($_SESSION['isAdmin']))||$_SESSION['isAdmin']!=1){
          header("Location: ../html/home.php");
      }
include '../php/connection.php';
$error = mysqli_connect_error();
if($error != null){
    $output = "Unable to connect to database!";
    echo "<script type='text/javascript'>alert('$output');</script>";
    exit($output);
}
$bad = false;
$stmt2 = mysqli_query($connection,"SELECT name FROM Products");
while($row2 = $stmt2->fetch_assoc()){
    if($_POST['name']==$row2['name']){
        $bad=true;
        echo "<p>Product ".$_POST['name']." already exists</p>";
    }
}
if(($_POST['name'])==""||$_POST['name']==null){
    $bad = true;
}
if(($_POST['price'])==""||$_POST['price']==null){
    $bad = true;
}
if(($_POST['category'])==""||$_POST['category']==null){
    $bad = true;
}
if(($_POST['price'])==""&&$_POST['price']==null){
    $bad = true;
}

if(($_FILES['image']['name'])!=""&&$_FILES['image']!=null){
    //print_r($_FILES);
    $info = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
    $okayextn = Array('jpg','jpeg','gif','png');
    if(($size=getimagesize($_FILES['image']['tmp_name']))==FALSE){
        echo "failed";
        $bad  = true;
    }elseif($_FILES['image']['size']> 1000000){
        echo "file is too large";
        $bad = true;
    }elseif(!in_array($info,$okayextn)){
        echo $info;
        $bad= true;
        echo " is an invalid file type";
    }
}else{
    $bad = true;
}

if($bad == false){
    $stmt1 = $connection->prepare("SELECT catID FROM ProductCategory WHERE catName = ?");
    $stmt1->bind_param("s",$_POST['category']);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $row1 = $result1->fetch_assoc();
    if(isset($row1)){
        $stmt = $connection ->prepare("INSERT INTO Products(name,description,price,contentType,image,catID) VALUES(?,?,?,?,?,?)");
        $imgdata = file_get_contents(addslashes($_FILES['image']['tmp_name']));
        $info = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
        $null = null;
        $stmt ->bind_param("ssdsbi",$_POST['name'],$_POST['description'],$_POST['price'],$info,$null,$row1['catID']);
        $stmt ->send_long_data(4,$imgdata);
        $stmt->execute();
        $stmt->close();
        echo "<p>Product ".$_POST['name']." was inserted succesfully</p>"; 
        echo "<p>Redirecting to admin portal in 3 seconds</p>";
        echo "<meta http-equiv='Refresh' content=\"3; url='../html/adminPortal.php'\">";
    }else{
        $output1 = "Category does not exist.";
        echo "<script type='text/javascript'>alert('$output1');</script>";
        
    }
}else{
    echo "<p>Invalid data sent</p>";
    echo "<p>Redirecting to add product in 3 seconds</p>";
    echo "<meta http-equiv='Refresh' content=\"3; url='../html/addProduct.php'\">";
}
    


    
?>