<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/social.css" media="all">
    <title>Login</title>
</head>
<body>
<div class="con">
<nav>

<a href="registration.php" target="_blank">Registation</a>
<a href="../home.html" target="_blank">Back to main page</a>
<a href="../profile.php">Profile</a>

</nav>
</div>
<div class="pravila">
<section><h2>Login here</h2>
<form action="login.php" method="post">
<label>Username as email:</label><br/>
<input type="email" name="username" maxlength="50" size="15" required autocomplete="off"/>
<br/>
<label>Password:</label><br/>
<input type="password" name="pass" required size="15" autocomplete="off"/>
<br/>
<input type="submit" value="Login"/>

</form>
<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
	if((!empty($_POST['username'])) && (!empty($_POST['pass']))){
		if((strtolower($_POST['username'])=='jbosnjak3@gmail.com') && ($_POST['pass']=='admin')){
			session_start();
			$_SESSION['username']=$_POST['username'];
			$_SESSION['login']=time();
			header('Location:../profile.php');
			exit();
		}else{
			die("Username and pass do not match!");
		}
	}else{
		die("You forgot username or pass");
	}
	
}else{
	print("<a href='../home.html'>Homepage</a>");
}

?>
</section>
</div>

</body>
</html>