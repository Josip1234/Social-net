
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
include('dbconn.php');
//include('functions.php');
$username=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['username'])));
if($username!=''){
    $pass=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['pass'])));
    //provjeri_dali_postoji_u_bazi($username,$pass);
    if($pass!=''){
        $res="SELECT email FROM registration WHERE email='$username'";
        mysqli_query($dbc,$res);
        if($res){
            $res2="SELECT id FROM registration WHERE email='$username'";
            mysqli_query($dbc,$res2);
            if($res2){
    $res3="SELECT pass FROM registration WHERE email='$username'";
    mysqli_query($dbc,$res2);
    if($res3){
        session_start();
        $_SESSION['email']= $_POST['username'];
        $_SESSION['pass']=$_POST['pass'];
        $_SESSION['islogged']=time();
        header('Location:trenutnifeedback.php');
    }
            }
        }
    }
    
 
}


?>
</section>
</div>



</body>
</html>