<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Checkout</title>
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css"/>
    <link rel="stylesheet" href="../css/common.css"/>
  </head>

  <body>
    <?php include 'header.php'; ?>
      
    <main>
  <div class="container" id="checkout">
    <h1>Billing and Payment</h1>
    <p class="break"></p>
    <form method="post" action="../php/checkoutAction.php">
        <div id = "info">
            <label class="infotitle">First Name</label>
            <label class="infotitle">Last Name</label>
            <label class="infotitle">Address 1</label>
            <label class="infotitle">Address 2 (Optional)</label>
            <label class="infotitle">Country</label>
            <label class="infotitle">Province</label>
            <label class="infotitle">City</label>
            <label class="infotitle">Postal Code</label>
            
            <input type="text" id="first" placeholder="First Name" name="first"required/>
            <input type="text" id="last" placeholder="Last Name" name="last" required/>
            <input type="text" id="add1" placeholder="Address" name="add1" required/>
            <input type="text" id="add2" placeholder="Address 2" name="add2"/>
            <input type="text" id="country" placeholder="Country" name="country" required/>
            <select id="province" name="province" required>
                <option value="AB">Alberta</option>
                <option value="BC">British Columbia</option>
                <option value="MB">Manitoba</option>
                <option value="NB">New Brunswick</option>
                <option value="NL">Newfoundland and Labrador</option>
                <option value="NS">Nova Scotia</option>
                <option value="ON">Ontario</option>
                <option value="PE">Prince Edward Island</option>
                <option value="QC">Quebec</option>
                <option value="SK">Saskatchewan</option>
                <option value="NT">Northwest Territories</option>
                <option value="NU">Nunavut</option>
                <option value="YT">Yukon</option>
            </select>
            <input type="text" id="city" placeholder="city" name="city" required/>
            <input type="text" id="postal" placeholder="Postal Code" name="postal" required/>
            
        </div>
        <p class="break"></p>
        <div id="payment">
            <label class="infotitle">Payment Type</label>
            <label class="infotitle">Cardholder Name</label>
            <label class="infotitle">Card Number</label>
            <label class="infotitle">Expiry Date</label>
            <label class="infotitle">CVV</label>
        
            <select id="cardType" name="cardType" required>

                <option value="visa">VISA</option>
                <option value="master">Master Card</option>
            </select>
            <input type="text" id="cardName" placeholder="Cardholder Name" name="cardName" required/>
            <input type="text" id="number" placeholder="Card Number" name="number" required/>
            <input type="text" id="expire" placeholder="Expiry Date" name="expire" required/>
            <input type="text" id="cvv" placeholder="CVV" name="cvv" required/>
            
        </div>
        <p class="break"></p>
        <div id="tax">
            <h3 class="sub">Subtotal</h3>
            <?php
              $userName = $_SESSION['username'];
          
              $stmt = $connection->prepare("SELECT userID FROM User WHERE userName = ?");
              $stmt->bind_param("s",$userName);
              $stmt->execute();
              $stmt->bind_result($uID);
              $stmt->fetch();
              
              $id = $uID;
              

              $stmt = $connection->prepare("SELECT SUM(price*amount) AS cost FROM Cart WHERE userID = ? GROUP BY price*amount");

              $stmt = $connection->prepare("SELECT SUM(price*amount) FROM Cart WHERE userID = ? GROUP BY userID");

              $stmt->bind_param("i",$id);
              $stmt->execute();
              $result = $stmt->bind_result($subTotal);
              $stmt->fetch();
              
              
              $tax = 0.12 * $subTotal;
              $total = $subTotal + $tax;
          
              
              
          
              printf('<p class="money">$%.2f</p>',$subTotal);
              printf('<h3 class="sub">Tax</h3><p class="money">$%.2f</p>',$tax);
              printf(' </div>
        <p class="break"></p>
        <div id="total">
            <h2>Total</h2>
            <p class="inline">$%.2f</p>',$total);
            ?>
          
            
            
            
       
        </div>
      <br>
      <input id="checkoutSubmit" class="submit" type="submit" value="Check Out"/>
    </form>
    </div>
        </main>
      
      <?php
      include 'footer.php';
      ?>
  </body>

</html>