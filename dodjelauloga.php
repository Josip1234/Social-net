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
<div class="pravila">
<section>
<h2>Dodjeli uloge</h2>
<form action="dodjelauloga.php" method="post">
<select name="selectko">
<?php
$sqlquery="SELECT email FROM registration";
$res=mysqli_query($dbc,$sqlquery);
while($r=mysqli_fetch_array($res)){
?>


  <?php
  
  echo "<option value='email'>".$r['email']."</option>";
};
mysqli_close($dbc);
  ?>
</select><br/>
<select name="uloge">
<option value="Administrator">Administrator</option>
<option value="Korisnik">Korisnik</option>
<option value="Banovani korisnik">Banovani korisnik</option>
</select><br/>
<input type="submit" value="Set_role">
</form>

</section>
</div>



</body>
</html>
