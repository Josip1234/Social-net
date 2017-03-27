<?php
include "dbconn.php";
session_start();
if(!isset($_SESSION['username'])){
	header('Location:login.php');
}else{
	$_SESSION['login']=time();
	$username=$_SESSION['username'];
	$imageType=$_SESSION['imageType'];
	$imageData=$_SESSION['imageData'];
	$imageId=$_SESSION['imageId'];
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
<section>
<?php
echo '<img src="data:'.$imageType.';base64,'.base64_encode( $imageData ).'"/> ';
?>
<form action="save_history.php" method="post">
<input type="submit" value="Insert into history"/>
</form>
<?php
$ima =addslashes(file_get_contents($_FILES[$imageData][$imageType]));
$imag = getimageSize($_FILES[$imageData][$imageType]);
$imageD=$_POST[$ima];
$imagP=$_POST[$imag];
$sql="INSERT INTO imagehistory(useremail,imageId,imageType,imageData VALUES '$username','$imageId',{$imageP['mime']}', '{$imageD}'";
mysqli_query($dbc,$sql);
mysqli_close($dbc);
?>


</section>
</div>



</body>
</html>
