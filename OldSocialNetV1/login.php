<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<script src="socialnet.js"></script>
<script src="calendar.js"></script>
</head>

<?php include "functions.php"; echo printBodyOnMouseOver(); ?>

<div class="con">
<nav>
<?php include "navigacija.php"; ?>
</nav>
</div>
<?php echo printCalendar(); ?>
<div class="pravila">
<section><h2>Login here</h2>
<form action="login.php" method="post">
<label>Username:</label><br/>
<input type="text" name="email" maxlength="50" size="15" required autocomplete="off" placeholder="Enter your email"/>
<br/>
<label>Password:</label><br/>
<input type="password" name="pass" required size="15" autocomplete="off"/>
<br/>
<input type="submit" value="Login"/>

</form>
<?php 
if($_SERVER["REQUEST_METHOD"]==="POST"){
$username=mysqli_real_escape_string($dbc,trim(strip_tags($_POST["email"])));
if($username!=''){
    $pass=mysqli_real_escape_string($dbc,trim(strip_tags($_POST["pass"])));
    provjeri_dali_postoji_u_bazi($username,$pass);
}
}


?>
</section>
</div>


<?php 
echo printFooter();
?>
</body>
</html>