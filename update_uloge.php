<?php
include ("dbconn.php");
session_start();
if(!isset($_SESSION['username'])){
	header('Location:login.php');
}else{
	if($_SESSION['role']!="Administrator"){
			 header('Location:profile.php');
		 }else{
			$_SESSION['login']=time();
			
		 }
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

<a href="registration.php" target="_self">Registation</a>
<a href="login.php" target="_self">Login</a>
<a href="privacy.php" target="_self">Terms of privacy</a>
<a href="trenutnifeedback.php" target="_self">Feedbacks-only for admins</a>
<a href="profile.php" target="_self">Profile of user</a>
<a href="logout.php" target="_self">Logout</a>
<a href="dodjelauloga.php" target="_self">Set user roles</a>
<a href="feedback.php" target="_self">Add feedback</a>
</nav>
</div>
<ul>
<li><a href="terminirajprofil.php" target="_self">Delete profile</a></li>
<li><a href="profilna.php" target="_self">Add profile picture</a></li>
<li><a href="updateprofilne.php" target="_self">Update profile picture</a></li>
</ul>
<div class="pravila">
<section>
<?php
$e=$_SESSION['selektiraj'];
$upit="SELECT uloga FROM registration WHERE email = '$e'";
$t=mysqli_query($dbc,$upit);
while($ro=mysqli_fetch_array($t)){
	if(mysqli_num_rows<2){
	      $t=$ro['uloga'];
	}else{
		die("Too many users select only one");
	}

?>
<form action="update_uloge.php" method="post">
<label>Uloga:</label><br/>
<input type="text" name="uloga1" value="<?php echo $ro['uloga']; };?>"><br/>
<input type="submit" value="Update role">

</form>
<?php
$uloga1=$_POST['uloga1'];
if($_SERVER['REQUEST_METHOD']=='POST'){
	if($t!=$uloga1){
		$upit2="UPDATE registration SET uloga='$uloga1' WHERE email='$e'";
		$u=mysqli_query($dbc,$upit2);
		if($u){
			echo "Succesfully updated user role";
			$_SESSION['selektiraj']=session_unset();
		    $_SESSION['selektiraj']=session_destroy();
			mysqli_close($dbc);
	
		}else{
			echo "Update failed please try again";
			$_SESSION['selektiraj']=session_unset();
		    $_SESSION['selektiraj']=session_destroy();
			
		   
			mysqli_close($dbc);
		}
	}else{
		echo "Nothing changed";
		$_SESSION['selektiraj']=session_unset();
		$_SESSION['selektiraj']=session_destroy();
		
		
		mysqli_close($dbc);
	}
}
?>
</section>
</div>


<footer>
<p id="datum"></p>
</footer>
</body>
</html>
