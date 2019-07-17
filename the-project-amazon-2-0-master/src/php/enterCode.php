<!DOCTYPE HTML>
<html lang="en">
<?php
$emailCode = generateRandomString(5);

if(isset($_POST['email'])){
$to = $_POST['email'];
$subject = "Password reset";
$txt = "Password reset code: ". $emailCode;
$headers = 'X-Mailer: PHP/' . phpversion();
mail($to,$subject,$txt,$headers);
echo $emailCode;
}

function generateRandomString($length){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>

</html>