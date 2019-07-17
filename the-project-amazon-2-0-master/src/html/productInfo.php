<!DOCTYPE html>
<html>
<?php

include 'header.php';

        if(isset($_GET['id'])){
            $sql = "SELECT * FROM Products WHERE prodID = '".$_GET['id']."'";
            $results = mysqli_query($connection, $sql);
            if(mysqli_num_rows($results)>0){
                $product = $results->fetch_assoc();
            }
            else{
                ?>
                    <script>
                    location.replace("login.php");
                    </script>
                <?php
            }
            if(isset($_SESSION['username'])){
                $sql = "SELECT * FROM User WHERE username = '".$_SESSION['username']."'";
                $results = mysqli_query($connection, $sql);
                $user = $results->fetch_assoc();
            }
        }
?>
    <head>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="../css/common.css" />
        <link rel="stylesheet" href="../css/productInfo.css" />
        <script type="text/javascript">
        window.jQuery ||
        document.write('<script src="../js/jquery-3.1.1.min.js"><\/script>')
        </script>
        <script>
            $(document).ready(function(){
             $("#addcart").click(function(e)
            {
                <?php
                if(isset($_SESSION['username'])){
                ?>
                    $("#myModal").css("display", "block");
                <?php
                }
                else{
                ?>
                    location.replace("login.php");
                <?php
                }
                ?>
            });
            $("#add").click(function(e)
            {
                <?php
                if(isset($_SESSION['username'])){
                ?>
                    var jqxhr = $.post("../php/addToCart.php", {price: <?php echo $product['price'] ?>, userID: <?php echo $user['userID'] ?>, prodID: <?php echo $_GET['id'] ?>, quantity: $('#quantity').val()});
                    jqxhr.done(function(results){
                        $("#myModal").css("display", "none");
                        alert("Item has been added to cart");
                    });
                <?php
                }
                else{
                ?>
                    location.replace("login.php");
                <?php
                }
                ?>
            });
            $(".close").click(function(e)
            {
                $("#myModal").css("display", "none");
            });
            $("#quantity").change(function(e)
            {
                $("#total").html('$'+(<?php echo $product['price']?>*$('#quantity').val()).toFixed(2));
            });
            $("#commentText").submit(function(e)
            {
                e.preventDefault();
                if($("#commentBox").val()!= ""){
                var jqxhr = $.post("../php/addComment.php", {comment: $("#commentBox").val(), prodID: <?php echo $_GET['id'] ?>});
                jqxhr.done(function(response){
                    $("#existingComments").load(location.href + " #existingComments", function(){
                        $("#existingComments:first-child").unwrap();
                    });
                    });
                }
                });
            });
        </script>
        </head>
        <body>
        
        <main>
            <br><br>
            <div id="myModal" class="modal">

        <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close">&times;</span>
                    <h2>Add to cart</h2>
                </div>
                <div class="modal-body">
                    <h3> <?php echo $product['name'] ?></h3>
                    <p>$<?php echo $product['price']?> </p>
                    <span>Quantity:   </span>
                    <input id="quantity" type="number" name="quantity" placeholder="1" value="1" min="0">
                    <h3>Total</h3>
                    <p id="total">$<?php echo $product['price']?></p>
                </div>
                <div class="modal-footer">
                    <button id="add" value="Add">Add</button>
                </div>
            </div>

            </div>
            
            <div id="top">
                <figure id="imageFigure">
                    <?php
                    echo '<img src="data:image/'.$product['contentType'].';base64,'.base64_encode($product['image']).'"id="productImage"alt="product image" title="product image"/>';
                    ?>
                </figure>
                <div id="productInfo">
                    <div class="itemTitle"><h1 id="productTitle"><?php echo $product['name']?></h1><input id="addcart" type="submit" id="search" class="material-icons md-24" value="add_shopping_cart"></div>
                    <h2 class="price">$<?php echo $product['price']?></h2>
                    <p class="description"><?php echo $product['description']?></p>
                </div>
            </div>
            <div id="bottom">
                <?php
                if(isset($_SESSION['username'])){
                ?>     
                <div id="userComment">
                    <h1>Comments</h1>
                    <?php echo '<img src="data:image/'.$user['contentType'].';base64,'.base64_encode($user['image']). '" id="userThumbnail"/>' ?>
                    <form id="commentText"> 
                        <fieldset>
                            <textarea id="commentBox" cols="30" rows="8" placeholder="Leave a comment..."></textarea>
                        </fieldset>
                        <input class="submit" type="submit" value="Submit"/>
                    </form>
                </div>
                <?php
                }
                ?>
                <div id="existingComments">
                    <?php
                    $sql = "SELECT Review.description, Review.revDate, User.username, User.image, User.contentType, User.userID FROM Review, User WHERE prodID = '".$_GET['id']."' AND Review.userID=User.userID ORDER BY Review.revDate DESC";
                    $result = mysqli_query($connection, $sql);
                    $numComments = mysqli_num_rows($result);
                    for($x = 0; $x < $numComments; $x++) {
                        $comments = $result->fetch_array(MYSQLI_ASSOC);
                        echo '<div class="comment">';
                        echo '<div class="commentTitle">';
                        echo '<span> <img src="data:image/'.$comments['contentType'].';base64,'.base64_encode($comments['image']). '" class="profileThumbnail"/><a href="comment.php?id='. $comments['userID'] .'"<h3>'. $comments['username'] .'</h3></a></span>';
                        echo '</div>';
                        echo '<p>'.$comments['description'].'</p>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </main>
        <footer>
            <figure id="footer-left">
                <p> <b>Contact Information</b> <br />Phone: 123-123-1234<br />Email: support@email.com</p>
            </figure>
            <figure id="footer-right">
                <p><b>Company Name</b> <br />Address of Company<br />City, Province <br />Country, Postal Code</p>
            </figure>
        </footer>
    </body>
</html>