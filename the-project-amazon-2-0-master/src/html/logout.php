<!DOCTYPE html>
<html>
<head>
    <title>logout</title>
    <link rel="stylesheet" href="../css/login.css">
    </head>
<body>
    <?php 
    include 'header.php';
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    
    }
    ?>
    <main>
    <h1>Logout of <?php echo $_SESSION['username']; ?></h1>
    <form method="post" action="../php/logout.php">
        <input id='big' type="submit" value="Logout">
        </form>
    
    </main>
    
    <?php
    include 'footer.php';
    ?>
    </body>

</html>