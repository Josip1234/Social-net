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

<a href="registration.php" target="_blank">Registation</a>
<a href="index.html" target="_blank">Back to main page</a>
<a href="privacy.php" target="_blank">Terms of privacy</a>
<a href="trenutnifeedback.php" target="_blank">Feedbacks-only for admins</a>
<a href="profile.php" target="_blank">Profile of user</a>
<a href="logout.php">Logout</a>
</nav>
</div>
<div class="pravila">
<section><h2>Login here</h2>
<form action="login.php" method="post">
<label>Username as email:</label><br/>
<input type="email" name="username"  maxlength="50" size="15" required autocomplete="off"/>
<br/>
<label>Password:</label><br/>
<input type="password" name="pass"  required size="15" autocomplete="off" />
<br/>
<input type="submit" value="Login"/>

</form>
<?php


if($_SERVER['REQUEST_METHOD']=='POST'){
	if((!empty($_POST['username'])) && (!empty($_POST['pass']))){
		if((strtolower($_POST['username'])=='jbosnjak3@gmail.com') && ($_POST['pass']=='admin')){
			session_start();
			$_SESSION['username']=$_POST['username'];
			$_SESSION['pass']=$_POST['pass'];
			$_SESSION['login']=time();
			header('Location:trenutnifeedback.php');
			exit();
		}
				
			
		
	
			
	
}else{   

	print("<a href='index.html'>Homepage</a>");
}
}
?>
</section>
</div>



</body>
</html>
