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

<a href="#" target="_blank">Registation</a>
<a href="#" target="_blank">Login</a>

</nav>
</div>
<div class="pravila">
<section>
<form action="terminirajprofil.php" method="post">
<label>Are you sure you want to terminate/delete your account?</label><br/>
<input type="checkbox" name="odgovor" value="yes">Yes 
<input type="checkbox" name="odgovor" value="no">No
<input type="submit" value="Confirm"> 
</form>
<?php
$odgovor=$_POST['odgovor'];

if($odgovor=='yes'){
	$upit="DELETE FROM registration WHERE email ='$username'";
	$o=mysqli_query($dbc,$upit);
	if($o){
		echo "Profile deleted"."<a href='index.html'>Back to homepage</a>";
		mysqli_close($dbc);
	}else{
		echo "Delete failed";
		mysqli_close($dbc);
	}
}else if($odgovor=='no'){
	header("Location:profile.php");
}
?>
</section>
</div>



</body>
</html>
