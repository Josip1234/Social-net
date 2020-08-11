<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location:login_system/login.php');
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
    <link rel="stylesheet" href="style/social.css" media="all">
    <title>Profile</title>
</head>
<body>
<body>

<div class="con">
<nav>

<a href="login_system/registration.php" target="_blank">Registation</a>
<a href="login_system/login.php" target="_blank">Login</a>
<a href="home.html">Back to main page</a>
<a href="login_system/logout.php" target="_blank">Logout</a>

</nav>
</div>
<div class="pravila">
<section><h2>Set your profile picture here</h2>
<?php
include('database/social_database_connection.php');
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
$sql = "INSERT INTO profile(imageType ,imageData,email)
VALUES('{$imageProperties['mime']}', '{$imgData}','$username')";
mysqli_query($dbc,$sql);


}}
?>
<form name="frmImage" enctype="multipart/form-data" action="profile.php" method="post" class="frmImageUpload">
<label>Upload Image File:</label><br/>
<input name="userImage" type="file" class="inputFile" />
<input type="submit" value="Submit" class="btnSubmit" />
</form>

<div class="pravila">
<section><h2>Your profile</h2>

<?php

$sql="SELECT `imageId`, `imageType`, `imageData` FROM `profile` WHERE `date_of_addition` = (SELECT MAX(`date_of_addition`) FROM profile WHERE email = '$username')";
$res=mysqli_query($dbc,$sql);
while($ro=mysqli_fetch_array($res)){
	echo "<label>User image:</label><br/>";
	echo '<img src="data:'.$ro['imageType'].';base64,'.base64_encode( $ro['imageData'] ).'"width="100" height="100"/> ';

	
	
	
	
}

$sql2="SELECT fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email FROM registration WHERE id = '$id'";
$t=mysqli_query($dbc,$sql2);
while($o=mysqli_fetch_array($t)){
	

	
	
?>	
	

<form action="profile.php" method="post">
<label>First name:</label><br/>
<input type="text" name="firstname1" value="<?php 
echo $o['fname'];
$fn=$o['fname'];

?>"/><br/><label>Last name:</label><br/>
<input type="text" name="lname1" value="
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
}

 ?>"/><br/>
<input type="submit" value="Update" />
</form>
<?php 

include ("database/social_database_connection.php");
$id1=$_SESSION['id'];
$firstname1=$_POST['firstname1'];
$lname1=$_POST['lname1'];
$sex1=$_POST['sex1'];
$datum1=$_POST['datum1'];
$cityofbirth1=$_POST['cityofbirth1'];
$countryofbirth1=$_POST['countryofbirth1'];
$pass1=$_POST['pass1'];
$email1=$_POST['email1'];
echo $id1;
echo $firstname1;
echo $lname1;
echo $sex1;
echo $datum1;
echo $cityofbirth1;
echo $countryofbirth1;
echo $pass1;
echo $email1;

if($_SERVER['REQUEST_METHOD']=='POST'){
    $query="UPDATE registration SET fname='$firstname1' WHERE id='$id'";
	$r=mysqli_query($dbc,$query);
	if($r){
	echo "Promijenjeno je prvo ime";
	}else{
		echo "Error updating table";
	}
};
if($lname1!=$ln){
	$query="UPDATE registration SET lname='$lname1' WHERE id='$id'";
	$r=mysqli_query($dbc,$query);
	if($r){
	echo "Promijenjeno je prezime";
	}else{
		echo "Update failed";
	}
};
if($sex1!=$s){
	$query="UPDATE registration SET sex='$sex1' WHERE id='$id'";
	$r=mysqli_query($dbc,$query);
	if($r){
	echo "Promijenjen je spol";
	}else{
		echo "Update failed";
	}
};
if($datum1!=$d){
	$query="UPDATE registration SET dateofbirth='$datum1' WHERE id='$id'";
	$r=mysqli_query($dbc,$query);
	if($r){
	echo "Promijenjen je datum";
	}else{
		echo "Update failed";
	};
}
if($cityofbirth1!=$c){
	$query="UPDATE registration SET cityofbirth='$cityofbirth1' WHERE id='$id'";
	$r=mysqli_query($dbc,$query);
	if($r){
	echo "Promijenjen je grad";
	}else{
		echo "Update failed";
	}
}
if($countryofbirth1!=$co){
	$query="UPDATE registration SET countryofbirth='$countryofbirth1' WHERE id='$id'";
	$r=mysqli_query($dbc,$query);
	if($r){
	echo "Promijenjena je država";
	}else{
		echo "Update failed";
	}
}
if($pass1!=$p){
	$query="UPDATE registration SET pass='$pass1' WHERE id='$id'";
	$r=mysqli_query($dbc,$query);
	if($r){
	echo "Promijenjena je šifra";
	}else{
		echo "Update failed";
	};
}
if($email1!=$e){ 
    $query="UPDATE registration SET email='$email1' WHERE id='$id'";
	$r=mysqli_query($dbc,$query);
	if($r){
	echo "Promijenjen je email";
	}else{
		echo "Update failed";
	}
}
    mysqli_close($dbc);

?>



</section>
</div>


</div>

</body>
</html>