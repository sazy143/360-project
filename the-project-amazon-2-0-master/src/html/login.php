<!DOCTYPE HTML>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>login</title>
  <link rel="stylesheet" href="../css/login.css"/>
  <script type="text/javascript">
    window.jQuery ||
    document.write('<script src="../js/jquery-3.1.1.min.js"><\/script>')
    </script>
    <?php
    session_start();
    if(isset($_SESSION['username'])&&$_SESSION['username']!=null&&$_SESSION['username']!=""){
        header("Location: home.php");
    }
    ?>
    <script>
        $(document).ready(function(){
        $(".submit").click(function(e){
            e.preventDefault();
            var jqxhr = $.post("../php/processLogin.php", {username: $("#username").val(), password: $("#password").val()});
            jqxhr.done(function(login){
                if(login.includes("1")){
                    window.location.replace("home.php");
                }
                else{
                    if($(".fail").length == 0){
                    var failMessage = $('<span class="fail"> Username or password is incorrect</span>');
                    $("#loginForm").append(failMessage);
                    }
                }
            });
        });
    });
    </script>

  </head>

  <body>
      <main>
  <div class="container" id="login">
    <h1>Login</h1>
    
    <form id="mainForm">
        <div id="loginForm">
            <label class="infotitle">Username</label>
            <label class="infotitle">Password</label>
            <input type="text" id="username" placeholder="Username" required/>
            <input type="password" id="password" placeholder="Password" required/>
        </div>
        <p><a href="register.html">Create Account</a></p>
        <p><a href="forgot.html">Forgot Password?</a></p>

        <input class="submit" type="submit" value="Log In"/>
    </form>
    </div>
      </main>
  </body>

</html>