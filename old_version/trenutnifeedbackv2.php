<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
<link href="css/stil.css" rel="stylesheet">
<script src="js/social.js"></script>
<script src="js/calendar.js"></script>
<script src="js/randomslike.js"></script>
</head>

<body onMouseOver="prikazi_datum(),dohvati_kalendar()", onLoad="slike()">

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
<a href="forum.php" target="_self">Forum</a>
</nav>
</div>
<ul id="f1">
<li><a href="#" onMouseOver="openmenu('m1')" onMouseOut="menuclosetime()">Opcije profila</a>
<div id="m1" onMouseOver="menucanceltime()" onMouseOut="menuclosetime()">
<a href="terminirajprofil.php" target="_self">Delete profile</a>
<a href="profilna.php" target="_self">Add profile picture</a>
<a href="updateprofilne.php" target="_self">Update profile picture</a>
<a href="Galerija.html" target="_self">Picture gallery</a>
</div>
</li>
</ul>
<div style="clear:both"></div>
<section id="cal">
<h2>Calendar for March 2017</h2>
<p id="calendar"></p>

</section>
<section id="randslike">
<h2>Random slike</h2>
<p id="s"></p>

</section>
<section id="valut">
	<iframe src="valutaV3.html" seamless></iframe>
</section>	
<div class="pravila">
<section id="sec"><h2>Feedbackovi</h2>

<form action="trenutnifeedbackv2.php" method="post">
<label>Select comment:</label><br/>
<select id="sel" name="select" onChange="selected2(this.value)">
<?php
$query="SELECT id,suggestion FROM kvaliteta";
$a=mysqli_query($dbc,$query);
while($res=mysqli_fetch_array($a)){
	echo "<option value='".$res['id']."'>".$res['suggestion']."</option>";
}
$sel=$_POST['select'];

?>
</select>
<input type="submit" value="Select" onClick="selected2("<?php $sel ?>")">

</form>

<section id="sv">
	
</section>
</section>
</div>



<footer>
<p id="datum"></p>
</footer>
</body>
</html>
</body>
</html>