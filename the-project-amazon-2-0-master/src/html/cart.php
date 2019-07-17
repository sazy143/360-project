<!DOCTYPE html>
<html>
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/common.css" />
    <link rel="stylesheet" href="../css/cart.css" />
    <script type="text/javascript">
    window.jQuery ||
    document.write('<script src="../js/jquery-3.1.1.min.js"><\/script>')
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
          $(".item input").change(function(e){
              var amount = $(e.currentTarget).val();
              var ID = $(e.currentTarget.parentNode.childNodes[2]).attr("id");
              
              var data = $.post("../php/cartAction.php", {prodID: ID, newAmount: amount});
              
              var $cart = $('.item');
              var subtotal = parseFloat(0.00);
            
              for(i = 0; i < $cart.length; i++){
              var item = $cart[i];
              var price = parseFloat($(item.childNodes[3]).html().substring(1));
              var amnt = parseFloat($(item.childNodes[4]).val());
            
              
                subtotal += price * amnt;
              }
              
                var tax = 0.12 * subtotal;
                var total = subtotal + tax;
            
               
            
                var newTotals = '<h2>Subtotal</h2><span id="subtotal">$' + subtotal.toFixed(2) + '</span>'+'<h2>Tax</h2><span id="tax">$' + tax.toFixed(2) + '</span>'+'<h2>Total</h2><span id="total">$' + total.toFixed(2) + '</span>';
            
                
                 document.getElementById("totals").innerHTML = newTotals;
          });
          
          $(".item i").click(function(e){
  
            var itemID = parseInt($(e.currentTarget.parentNode.childNodes[2]).attr("id"));
            var uID = 1;
            
            var data = $.post("../php/cartDelete.php", {prodID: itemID, userID: uID});
            data.done(function(results){
            
            e.currentTarget.parentElement.remove();
            
            var $cart = $('.item');
              var subtotal = parseFloat(0.00);
              console.log(cart.length);
              for(i = 0; i < $cart.length; i++){
              var item = $cart[i];
              var price = parseFloat($(item.childNodes[3]).html().substring(1));
              var amnt = parseFloat($(item.childNodes[4]).val());
            
              
                subtotal += price * amnt;
              }
              
                var tax = 0.12 * subtotal;
                var total = subtotal + tax;
            
               
            
                var newTotals = '<h2>Subtotal</h2><span id="subtotal">$' + subtotal.toFixed(2) + '</span>'+'<h2>Tax</h2><span id="tax">$' + tax.toFixed(2) + '</span>'+'<h2>Total</h2><span id="total">$' + total.toFixed(2) + '</span>';
            
                
                 document.getElementById("totals").innerHTML = newTotals;
            });
          });
          
          $("#checkoutButton").click(function(e){
              
              
          });
          
        });
    
  
    
  </script>
</head>
<body>
<?php
    include 'header.php';
    if(!isset($_SESSION['username'])){
    ?>
    <script>
      window.location.replace("login.php");
    </script>
    <?php
    }
?>
<main>
    <div id="cartItems">
        <h1 id="cartTitle">Cart</h1>
        <?php
        error_reporting(E_ALL);
ini_set('display_errors', 1);
        try{
            
              
              $userName = $_SESSION['username'];
              
              $stmt = $connection->prepare("SELECT userID FROM User WHERE userName = ?");
              $stmt->bind_param("s",$userName);
              $stmt->execute();
              $stmt->bind_result($uID);
              $stmt->fetch();
              $id = $uID;
              $stmt->close();
            $subtotal = 0;
                        
           // $sql = $connection->prepare("SELECT Products.name, Products.price, Products.prodID, Cart.amount, Products.image, Products.contentType FROM Products,Cart Where Cart.userID = ? AND Products.prodID = Cart.prodID");
            $sql = "SELECT name,p.price,p.prodID,amount,image,contentType FROM Products as p, Cart WHERE Cart.userID = ? AND p.prodID = Cart.prodID";
           
            //$sql = "SELECT `foo` FROM `weird_words` WHERE `definition` = ?";
            if($query = $connection->prepare($sql)) { // assuming $mysqli is the connection
                    $query->bind_param('i', $id);
            $query->execute();
    // any additional code you need would go here.
            } else {
                $error = $connection->errno . ' ' . $connection->error;
                echo $error; // 1054 Unknown column 'foo' in 'field list'
            }
            //$test->bind_param("i",$id);
            //$test->execute();
            $query->bind_result($name,$price,$prodID,$amount,$image,$contentType);
            
                    $count = 1;
                    
          while($query->fetch()){
                        
                        $subtotal += $price * $amount;
                        
                        echo '<div class="item" id="item' . $count . '"' . $count . '">'
                        . '<i id="delete' . '" class="material-icons md-24">clear</i>'
                        . '<figure>'
                        . '<img src="data:image/'.$contentType.';base64,'.base64_encode($image).'"id="productImage"alt="product image" title="product image"/>'
                        . '</figure>'
                        . '<h2 class="itemTitle" id="' . $prodID . '">' . $name . '</h2>'
                        . '<h3 class="price">$' . $price . '</h3>'
                        . '<input type="number" name="quantity1" placeholder="' . $amount . '"value="' . $amount .'" min="0">'
                        . '</div>';
                        
                        $count++;
                    }
                }
        catch(Exception $e){
            
        }
        ?>
        
      
        
    </div>
    <div id="details">
    <div id="totals">
      <?php
        $tax = $subtotal * 0.12;
        $total = $tax + $subtotal;
        printf('<h2>Subtotal</h2><span id="subtotal">$%.2f</span>',$subtotal);
        printf('<h2>Tax</h2><span id="tax">$%.2f</span>',$tax);
        printf('<h2>Total</h2><span id="total">$%.2f</span>',$total);
      ?>
        
        
        
    </div>
    <a id="checkoutButton" href="checkout.php">CHECKOUT</a>
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