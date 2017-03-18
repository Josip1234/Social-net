<?php
include("dbconn.php");
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
	$id=$_SESSION['id'];
	$username=$_SESSION['username'];
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

<a href="#" target="_self">Registation</a>
<a href="#" target="_self">Login</a>
<a href="logout.php" target="_self">Logout</a>
<a href="trenutnifeedback.php" target="_self">Feedback</a>
</nav>
</div>
<div class="pravila">
<section><h2>Your profile</h2>
<?php

$sql="SELECT imageId,imageType,imageData FROM profilna WHERE email = '$username'";
$res=mysqli_query($dbc,$sql);
while($ro=mysqli_fetch_array($res)){
	echo "<label>User image:</label><br/>";
	echo '<img src="data:'.$ro['imageType'].';base64,'.base64_encode( $ro['imageData'] ).'"width="100" height="100"/> ';

	
	
	
	
}
$sql2="SELECT fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email,uloga FROM registration WHERE id = '$id'";
$t=mysqli_query($dbc,$sql2);
while($o=mysqli_fetch_array($t)){
	

	
	
?>	
	

<form action="profile.php" method="post">
<label>First name:</label><br/>
<input type="text" name="firstname" value="<?php 
echo $o['fname'];

?>"/><br/><label>Last name:</label><br/>
<input type="text" name="lastname" value="
<?php
echo $o['lname'];

?>


" 

/><br/><label>Sex:</label><br/>
<input type="text" name="sex" value="<?php
echo $o['sex'];

?>"/><br/><label>Date of birth:</label><br/>
<input type="date" name="datum" value="<?php 
echo $o['dateofbirth'];

 ?>"/><br/><label>City of birth:</label><br/>
 
 <input type="text" name="cityofbirth" value="<?php 
echo $o['cityofbirth'];

 ?>"/><br/><label>Country of birth:</label><br/>
 
 <input type="text" name="countryofbirth" value="<?php 
echo $o['countryofbirth'];

 ?>"/>
  <br/><label>Pass:</label><br/>
 <input type="text" name="pass" value="<?php 
echo $o['pass'];

 ?>"/><br/><label>Email:</label><br/>
 <input type="email" name="email" value="<?php 
echo $o['email'];


 ?>"/><br/><label>Role:</label><br/>
 <input type="text" name="uloga" value="<?php 
echo $o['uloga'];
$ul=$_SESSION[$o['uloga']];
if($ul=="Korisnik"){
	
	$_SESSION['username']=$_POST['email'];
	$_SESSION['uloga']=$_POST[$ul];
}else if($ul=="Administrator"){
	$_SESSION['username']=$_POST['email'];
	$_SESSION['uloga']=$_POST[$ul];
}
}
mysqli_close($dbc);
?>"/><br/>
<input type="submit" value="Update" />
</form>




</section>
</div>



</body>
</html>
