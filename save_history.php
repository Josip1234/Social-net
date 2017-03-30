<?php

session_start();
if(!isset($_SESSION['username'])){
	header('Location:login.php');
}else{
	$_SESSION['login']=time();
	$email=$_SESSION['username'];
	$imageType=$_SESSION['imageType'];
	$imageData=$_SESSION['imageData'];
	$img=$_SESSION['imageId'];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<script language="JavaScript" src="js/drustvenijs.js" type="application/javascript"></script>
</head>

<body onMouseOver="prikazi_datum()">

<div class="con">
<nav>

<a href="#" target="_blank">Registation</a>
<a href="#" target="_blank">Login</a>

</nav>
</div>
<div class="pravila">
<section>
<?php
include "dbconn.php";
echo '<img src="data:'.$imageType.';base64,'.base64_encode( $imageData ).'"/> ';
echo $img;
?>
<form action="save_history.php" method="post">
<input type="file" name="userImage">
<input type="submit" value="Insert into history"/>
</form>
<?php
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);


$sql="INSERT INTO imagehistory(imageId,imageType,imageData,email VALUES ,'$id',{$imageProperties['mime']}', '{$imageData}','$email'";
mysqli_query($dbc,$sql);

mysqli_close($dbc);
}}
?>


</section>
</div>

<footer>
<p id="datum"></p>
</footer>

</body>
</html>
