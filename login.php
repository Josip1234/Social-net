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

<a href="registration.php" target="_self">Registation</a>
<a href="index.html" target="_self">Back to main page</a>
<a href="privacy.php" target="_self">Terms of privacy</a>
<a href="trenutnifeedback.php" target="_self">Feedbacks-only for admins</a>
<a href="profile.php" target="_self">Profile of user</a>
<a href="logout.php" target="_self">Logout</a>
<a href="dodjeli_uloge.php" target="_self">User roles</a>
</nav>
</div>
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
$upit="SELECT id,email,pass FROM registration WHERE email='$username' AND pass='$pass'";
$r=mysqli_query($dbc,$upit);
while($res=mysqli_fetch_array($r)){
	if(mysqli_num_rows($res)<2){
		$upit2="SELECT id,email,uloga FROM uloge WHERE email='$username'";
		$z=mysqli_query($dbc,$upit2);
		while($rs=mysqli_fetch_array($z)){
			if(mysqli_num_rows($rs)<2){
				$role="Administrator";
				$uloga=$_POST['role'];
				if($uloga=="Administrator"){
					$role=$_SESSION[$uloga];
				}
			}
		}
		 session_start();
		 $_SESSION['id']=$res['id'];
		 $_SESSION['username']=$res['email'];
		 $_SESSION['pass']=$res['pass'];
		 $_SESSION['login']=time();
		 $_SESSION['role']=$role;
		 header('Location:profile.php');
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



</body>
</html>
