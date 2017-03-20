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
<input type="text" name="firstname1" value="<?php 
echo $o['fname'];
$fn=$o['fname'];

?>"/><br/><label>Last name:</label><br/>
<input type="text" name="lastname1" value="
<?php
echo $o['lname'];
$ln=$o['lname'];
?>


" 

/><br/><label>Sex:</label><br/>
<input type="text" name="sex1" value="<?php
echo $o['sex'];
$s=$o['sex'];

?>"/><br/><label>Date of birth:</label><br/>
<input type="date" name="datum1" value="<?php 
echo $o['dateofbirth'];
$d=$o['dateofbirth'];

 ?>"/><br/><label>City of birth:</label><br/>
 
 <input type="text" name="cityofbirth1" value="<?php 
echo $o['cityofbirth'];
$c=$o['cityofbirth'];

 ?>"/><br/><label>Country of birth:</label><br/>
 
 <input type="text" name="countryofbirth1" value="<?php 
echo $o['countryofbirth'];
$co=$o['countryofbirth'];

 ?>"/>
  <br/><label>Pass:</label><br/>
 <input type="text" name="pass1" value="<?php 
echo $o['pass'];
$p=$o['pass'];
 ?>"/><br/><label>Email:</label><br/>
 <input type="email" name="email1" value="<?php 
echo $o['email'];
$e=$o['email'];


 ?>"/><br/><label>Role:</label><br/>
 <input type="text" name="uloga1" value="<?php 
echo $o['uloga'];
$u=$o['uloga'];
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
<?php
include ("dbconn.php");
$id1=$_SESSION['id'];
$firstname1=$_POST['firstname1'];
$lastname1=$_POST['lastname1'];
$sex1=$_POST['sex1'];
$datum1=$_POST['datum1'];
$cityofbirth1=$_POST['cityofbirth1'];
$countryofbirth1=$_POST['countryofbirth1'];
$pass1=$_POST['pass1'];
$email1=$_POST['email1'];
$uloga1=$_POST['uloga1'];
echo $id1;
echo $firstname1;
echo $lastname1;
echo $sex1;
echo $datum1;
echo $cityofbirth1;
echo $countryofbirth1;
echo $pass1;
echo $email1;
echo $uloga1;
if($_SERVER['REQUEST_METHOD']=='POST'){
if($firstname1!=$fn){
	echo "Promijenjeno je prvo ime";
};
if($lastname1!=$ln){
	echo "Promijenjeno je prezime";
};
if($sex1!=$s){
	echo "Promijenjen je spol";
};
if($datum1!=$d){
	echo "Promijenjen je datum";
}
if($cityofbirth1!=$c){
	echo "Promijenjen je grad";
}
if($countryofbirth1!=$co){
	echo "Promijenjena je država";
}
if($pass1!=$p){
	echo "Promijenjena je šifra";
}
if($email1!=$e){ 
	echo "Promijenjen je email";
}
if($uloga1!=$u){
	echo "Promijenjena je uloga";
}
mysqli_close($dbc);
}else{
	echo "";
}
?>



</section>
</div>



</body>
</html>
