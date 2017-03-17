<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
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
</head>

<body>

<div class="con">
<nav>

<a href="#" target="_self">Registation</a>
<a href="#" target="_self">Login</a>
<a href="trenutnifeedback.php" target="_self">Feedbacks-only for admins</a>
<a href="profile.php" target="_self">Profile of user</a>
<a href="logout.php" target="_self">Logout</a>
</nav>
</div>


<div class="pravila">
<section>
<h2>Set the role of one user:</h2>
<form action="dodjeli_uloge.php" method="post">
<label>Email of the user which you want so set his role:</label><input type="email"  name="user"autocomplete="off" required /><br/>
<label>User role:</label><input type="text" name="s" value="Administrator,korisnik ili banovani korisnik" required/>
<input type="submit" value="Set_role"/>

</form>
<?php
include("dbconn.php");
$email=$_POST['user'];
$s=$_POST['s'];
if($email!=''){
	if($s!=''){
		if($s=="Administrator"){}else
		if($s=="Korisnik"){}else 
		if($s=="Banovani korisnik"){}else{die("Invalid role");};
	}else{
		die("Missing role");
	}
}else{
	die("Email missing");
}
	


?>
</section>
</div>

</body>
</html>