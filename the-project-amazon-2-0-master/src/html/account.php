<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Account Info</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../css/login.css"/>
    <link rel="stylesheet" href="../css/common.css"/>
    <script type="text/javascript">
    window.jQuery ||
    document.write('<script src="../js/jquery-3.1.1.min.js"><\/script>')
    </script>
    <script>
      $(document).ready(function() {
          $("#updateInfo").click(function(e){
              
            
              var firstName = $("#name").val();
              var lastName = $("#last").val();
              var userName = $("#username").val();
              var email = $("#email").val();
              
             $.post("../php/updateInfo.php", {fName: firstName, lName: lastName, uName: userName, e: email});
            alert("info updated");
              
          });
          
          $("#updatePassword").click(function(e){
            e.preventDefault();
            var password1 = document.getElementById("new").value;
            var password2 = document.getElementById("re").value;
            var password = document.getElementById("old").value;

            if (password1!=password2){
                alert("passwords don't match!");
            }else{
              var jqxhr = $.post("../php/updatePassword.php", {newPassword: password1, oldPassword: password});
              jqxhr.done(function(response){
                console.log(response);
                alert("password updated.");
              });
              
            }
          });
          
        });
    
    </script>
    
  </head>

  <body>
 <?php
    include "header.php";
    ?>
    <main>
  <div class="container" id="accountdiv">
    <h1>Account Information</h1>
    <p class="break"></p>
    <h2>Basic Information</h2>
    <form id=basic>
        <div id="userinfo">
            <label class="infotitle">First Name:</label>
            <label class="infotitle">Last Name:</label>
            <label class="infotitle">Email:</label>
            <label class="infotitle">Username:</label>
          
          <?php
            
            $userName = $_SESSION['username'];
            
            $stmt = $connection->prepare("SELECT firstName, lastName, userName, email FROM User WHERE userName = ?;");
            $stmt->bind_param("s",$userName);
            $stmt->execute();
            $stmt->bind_result($firstName,$lastName,$userName,$email);
            $stmt->fetch();
            
            
               
          
              
           echo '<input type="text" id="name" name="name" value="' . $firstName . '" placeholder="' . $firstName . '" required/>'; 
           echo '<input type="text" id="last" name="last" value="' . $lastName . '" placeholder="' . $lastName . '" required/>';  
           echo '<input type="email" id="email" name="email" value="' . $email . '" placeholder="' . $email . '" required/>';
           echo '<input type="text" id="username" name="username" value="' . $userName . '" placeholder="' . $userName . '" required/>';
          
          $stmt->close();
          ?>
        </div>
        <br>
        <input class="update" id="updateInfo" type="submit" value="Update"/>
    </form>
    <p class="break"></p>
    <h2>Change Password</h2>
    <form id="password">
        <div id="reset">
            <label class="infotitle">Old Password</label>
            <label class="infotitle">New Password</label>
             <label class="infotitle">Retype Password</label>
            
            <input type="text" id="old" name="oldPassword" required/>
            <input type="text" id="new" name="newPassword" required/>
            <input type="text" id="re" required/>
        </div>
        <br>
        <input class="update" id="updatePassword" type="submit" value="Update"/>
    </form>
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