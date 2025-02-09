<?php 
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}else{
    $_SESSION['login']=time();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
</head>
<body>
    <div class="con">
<nav>
    <a href="#" target="_blank" rel="noopener noreferrer">Registration</a>
    <a href="#" target="_blank" rel="noopener noreferrer">Login</a>
</nav>
    </div>
    <div class="pravila">
<section>
    <h2>Your profile</h2>
    <img src="<?php ?>" alt="profile_picture"><br/>
    <?php //samo ispisujemo podatke ovdje trebamo stvoriti gumb za update, podaci se ispisuju prema id-u korisnika koji je trenutno ulogiran  ?>
</section>
    </div>
</body>
</html>