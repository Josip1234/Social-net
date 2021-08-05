<?php 
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}else{
    $id=$_SESSION['id'];
    $username=$_SESSION['username'];
    $_SESSION['login']=time();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/stil.css">
    <title>Socialnet</title>
</head>
<body>
    <div class="con">
        <nav>
            <a href="#" target="_blank">Registration</a>
            <a href="#" target="_blank">Login</a>
        </nav>

    </div>
    <div class="pravila">

    </div>
</body>
</html>