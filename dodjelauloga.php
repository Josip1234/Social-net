<?php
include "dbconn.php";
session_start();

if(!isset($_SESSION['username'])){
	header('Location: profile.php');
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

<a href="registration.php" target="_blank">Registation</a>
<a href="login.php" target="_blank">Login</a>
<a href="logout.php" target="_self">Logout</a>
<a href="feedback.php" target="_self">Add feedback</a>
</nav>
</div>
<ul>
<li><a href="terminirajprofil.php" target="_self">Delete profile</a></li>
</ul>
<div class="pravila">
<section>
<h2>Dodjeli uloge</h2>
<form action="dodjelauloga.php" method="post">
<select name="email">
<?php
$upit="SELECT email FROM registration";
$q=mysqli_query($dbc,$upit);
while($r=mysqli_fetch_array($q)){
	echo "<option value='".$r['email']."'>".$r['email']."</option>";
	echo $r['email'];
	
}

?>
</select>
<br/>
<input type="submit" value="Select email">
</form>
<?php
$email=$_POST['email'];
if($_SERVER['REQUEST_METHOD']=='POST'){
	$_SESSION['selektiraj']=$email;
	header('Location:update_uloge.php');
}
mysqli_close($dbc);


?>




</section>
</div>



</body>
</html>
