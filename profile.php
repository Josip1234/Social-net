<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
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

<a href="#" target="_blank">Registation</a>
<a href="#" target="_blank">Login</a>
<a href="logout.php" target="_blank">Logout</a>
</nav>
</div>
<div class="pravila">
<section><h2>Your profile</h2>
<?php
include("dbconn.php");
$sql="SELECT imageId,imageType,imageData FROM profilna WHERE email = '$username'";
$res=mysqli_query($dbc,$sql);
while($ro=mysqli_fetch_array($res)){
	
	echo '<img src="data:'.$ro['imageType'].';base64,'.base64_encode( $ro['imageData'] ).'"width="100" height="100"/> ';

	
	
	
	
}
mysqli_close($dbc);
?>





</section>
</div>



</body>
</html>
