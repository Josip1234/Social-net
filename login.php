<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<script language="JavaScript" src="js/drustvenijs.js" type="application/javascript"></script>
<script language="JavaScript" src="js/calendar.js" type="application/javascript"></script>
</head>

<body onMouseOver="prikazi_datum(),dohvati_kalendar()">

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
<section id="cal">
<h2>Calendar for March 2017</h2>
<p id="calendar"></p>

</section>
<div class="pravila">
<section><h2>Login here</h2>
<form action="" method="post">
<label>Username as email:</label><br/>
<input type="email" name="username"  maxlength="50" size="15" required autocomplete="off"/>
<br/>
<label>Password:</label><br/>
<input type="password" name="pass"  required size="15" autocomplete="off" />
<br/>
<input type="submit" value="Login"/>

</form>
<?php
include("dbconn.php");

$username=$_POST['username'];
if($username!=''){
$pass=$_POST['pass'];
if($pass!=''){
$upit="SELECT id,pass,email,uloga FROM registration WHERE email='$username' AND pass='$pass'";
$r=mysqli_query($dbc,$upit);
while($res=mysqli_fetch_array($r)){
	if(mysqli_num_rows($res)<2){
		        if($username==$res['email']){
					if($pass==$res['pass']){
						session_start();
						$_SESSION['username']=$_POST['username'];
						$_SESSION['role']=$res['uloga'];
						$_SESSION['id']=$res['id'];
						$_SESSION['pass']=$res['pass'];
						$_SESSION['login']=time();
						header('Location:trenutnifeedback.php');
					}
				}
				
		       
		
		
	}
	else{
		echo "Multiple users exists";
	}
}
}
}

mysqli_close($dbc);
?>
</section>
</div>


<footer>
<p id="datum"></p>
</footer>
</body>
</html>
