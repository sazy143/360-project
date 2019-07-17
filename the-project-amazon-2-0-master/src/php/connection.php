
<?php

$host = "localhost";
$database = "db_45705150";
$user = "45705150";
$password = "beans";

$connection = mysqli_connect($host, $user, $password, $database);
if (!$connection) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

    
    ?>
