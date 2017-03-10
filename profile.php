<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
	$_SESSION['login']=time();
}

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>

<div class="con">
<nav>

<a href="#" target="_blank">Registation</a>
<a href="#" target="_blank">Login</a>

</nav>
</div>
<div class="pravila">
<section><h2>Your profile</h2>
<img src="<?php ?>" alt="profile_picture"><br/>
<?php //samo ispisujemo podatke ovdje trebamo stvoriti gumb za update, podaci se ispisuju prema id-u korisnika koji je trenutno ulogiran ?>



</section>
</div>



</body>
</html>
