<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login concept page</title>
</head>
<body>
<?php

$username="";
$password="";
$remember="";


?>
    <form action="login_concept.php" method="post">
    <label for="username">Enter your username:</label>
    <input type="text" name="username" id="username">
    <label for="password">Enter your password:</label>
    <input type="password" name="password" id="password">
    <label for="remember">Remember me?</label>
    <input type="checkbox" name="remember" id="remember">
    <input type="submit" value="Login">
    </form>


    <?php  
         $username=$_POST['username'];
         $password=$_POST['password'];
         $remember=$_POST['remember'];

         if($_SERVER['REQUEST_METHOD']=='POST'){
                  
            echo $username."".$password."".$remember;
        
        };

?>
</body>
</html>