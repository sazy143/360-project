<!DOCTYPE html>

<?php

if($_SERVER['REQUEST_METHOD']!="POST"||!isset($_POST['product'])){
    print_r($_POST['product']);
    
}
$prodID = $_POST['product'];
include '../php/connection.php';
$error = mysqli_connect_error();
if($error != null){
    $output = "Unable to connect to database!";
    echo "<script type='text/javascript'>alert('$output');</script>";
    exit($output);
}

if(isset($_POST['delete'])){
    $stmt = $connection->prepare("DELETE FROM Products WHERE prodID = ?");
    $stmt->bind_param("i",$prodID);
    $stmt->execute();
    $stmt->close();
    echo "<p>Product with ID ".$prodID." was deleted<br>redirecting to admin portal in 10 seconds</p>";
    echo "<meta http-equiv='Refresh' content=\"10; url='../html/adminPortal.php'\">";
}else{
    if($_POST['description']!=""&&$_POST['description']!=null){
        $stmt = $connection->prepare("UPDATE Products SET description = ? WHERE prodID = ?");
        $stmt->bind_param("si",$_POST['description'],$prodID);
        $stmt->execute();
        $stmt->close();
        echo "<p>Description was changed.</p>";
    }

    if(($_POST['price'])!=""&&$_POST['price']!=null){
        $stmt = $connection->prepare("UPDATE Products SET price = ? WHERE prodID = ?");
        $stmt->bind_param("di",$_POST['price'],$prodID);
        $stmt->execute();
        $stmt->close();
        echo "<p>Price was changed.</p>";
    }

    if(($_FILES['image']['name'])!=""&&$_FILES['image']!=null){
        //print_r($_FILES);
        $info = pathinfo($_FILES['image']['name'],PATHINFO_EXTENSION);
        $okayextn = Array('jpg','jpeg','gif','png');
        if(($size=getimagesize($_FILES['image']['tmp_name']))==FALSE){
            echo "failed";
        }elseif($_FILES['image']['size']> 1000000){
            echo "file is too large";
        }elseif(!in_array($info,$okayextn)){
            echo $info;
            echo " is an invalid file type";
        }
        else{
            echo $info;
            $imgdata = file_get_contents(addslashes($_FILES['image']['tmp_name']));
            $stmt = $connection->prepare("UPDATE Products SET image = ?, contentType = ? WHERE prodID = ?");
            $null = NULL;
            $stmt->bind_param("bsi",$null,$info,$prodID);
            mysqli_stmt_send_long_data($stmt, 0, $imgdata);
            $stmt->execute();
            $stmt->close();
            echo "<p>Image was changed.</p>";
        }
    }

    if(($_POST['category'])!=""&&$_POST['category']!=null){
        $stmt = $connection->prepare("SELECT catID FROM ProductCategory WHERE catName = ?");
        $stmt->bind_param("s",$_POST['category']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if(isset($row)){
            $stmt1 = $connection->prepare("UPDATE Products SET catID = ? WHERE prodID = ?");
            $stmt1->bind_param("di",$row['catID'],$prodID);
            $stmt1->execute();
            $stmt1->close();
            echo "<p>Category was changed.</p>";
        }else{
            $output1 = "Category does not exist.";
            echo "<script type='text/javascript'>alert('$output1');</script>";
        }
        $stmt->close();
    }
    echo "<p>Redirecting to admin portal in 10 seconds</p>";
    echo "<meta http-equiv='Refresh' content=\"10; url='../html/adminPortal.php'\">";
   
}
    
?>