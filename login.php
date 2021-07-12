<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
</head>
<body>
    <div class="con">
        <nav>
            <a href="registration.php" target="_blank">Registration</a>
            <a href="index.html" target="_blank" >Back to main page</a>
            <a href="privacy.php" target="_blank" >Terms of privacy</a>
            <a href="trenutnifeedback.php" target="_blank" >Feedbacks - only for admins</a>
            <a href="profile.php" target="_blank">Profile of user</a>
        </nav>
    </div>
    <div class="pravila">
         <section>
             <h2>Login here</h2>
             <form action="login.php" method="post">

                 <label>Username:</label><br>
                 <input type="email" name="username" maxlength="50" size="15" required autocomplete="off">
                 <br>
                 <label>Password:</label><br>
                 <input type="password" name="pass" required size="15" autocomplete="off">
                 <br>
                 <input type="submit" value="Login">
             </form>
             <?php 
             include("dbconn.php");
if($_SERVER['REQUEST_METHOD']=='POST'){
	if((!empty($_POST['username'])) && (!empty($_POST['pass']))){
		if((strtolower($_POST['username'])=='jbosnjak3@gmail.com') && ($_POST['pass']=='admin')){
			session_start();
			$_SESSION['username']=$_POST['username'];
			$_SESSION['login']=time();
			header('Location:trenutnifeedback.php');
			exit();
		}else{
            $logiranikorisnik= mysqli_query($dbc,"SELECT id, pass, email FROM registration WHERE email='$username' AND pass='$pass'");
            if(mysqli_num_rows($logiranikorisnik==1)){
                $row=mysqli_fetch_array($logiranikorisnik);
                $_SESSION['username']=$username;
                $_SESSION['pass']=$pass;
                $_SESSION['login']=time();
                header("Location: index.html");
                echo "Successfull login";
            }else{
                echo "Another user is online";
            }
		}
	}else{
		die("You forgot username or pass");
	}
	
}else{
	print("<a href='index.html'>Homepage</a>");
}
mysqli_close($dbc);
             ?>
         </section>
    </div>
</body>
</html>