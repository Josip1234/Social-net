<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location:login.php');
}else{
	$_SESSION['login']=time();
	$username=$_SESSION['username'];
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>

<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<script  src="js/drustvenijs.js" type="text/javascript"></script>
<script language="JavaScript" src="js/calendar.js" type="application/javascript"></script>
<script src="js/dropdownmenu.js" type="application/javascript"></script>
<script src="js/randomslike.js" type="application/javascript"></script>

</head>

<body  onMouseOver="prikazi_datum(),dohvati_kalendar()" onLoad="slike()">
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
<a href="Galerija.html" target="_self">Picture gallery</a><a href="addtogallery.php" target="_self">Add to gallery</a>

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
	<iframe src="Pretvorba valuta/valuta.html" seamless></iframe>
</section>	


<div class="pravila">
<section>
<h2>Ovdje počinje forum</h2>

<div id="tema">
<?php  include("ispis_tema.php") ?>
</div>
<div id="podtema">
<h2>Forum</h2>
<div id="profil">
    <h3>Lijevo treba biti slika profila i ime</h3>
	<div id="odgovori">
		
	</div>
</div>
</div>
</section>
</div>


<footer>
<p id="datum"></p>
</footer>

</body>
</html>