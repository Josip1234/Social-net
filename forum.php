<?php
include("konfiguracija.php");
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
<script src="forforum.js" type="application/javascript"></script>
</head>

<body   onMouseOver="prikazi_datum(),dohvati_kalendar()" onLoad="slike(),hideDivs()">
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
<<<<<<< HEAD
<a href="Galerija.html" target="_self">Picture gallery</a><a href="addtogallery.php" target="_self">Add to gallery</a>

=======
>>>>>>> parent of ad58c11... napravljene galerije
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

<<<<<<< HEAD
<div class="pravila" >
<section>
=======
<div class="pravila">
<section >
>>>>>>> parent of ad58c11... napravljene galerije
<h2>Ovdje počinje forum</h2>
<input type="button"  value="New Topic" onClick="displayNew()">
<input type="button"  value="List exist topics" onClick="displayExist()">
	<div id="Kreiraj">
		<form action="konfiguracija.php" method="post">
			<label>User:</label><br>
			<input type="text" name="Korisnik" value="<?php echo $_SESSION['username'] ?>"/>
			<br>
			<label>Topic:</label><br>
			<input type="text" name="Tema"></br>
			<input type="submit" name="Add new Theme"/>
			<input type="button"  value="Hide form" onClick="hideNew()">
		</form>
	</div>
<div id="teme">
    <h3>List of exist Topics</h3>
    <ul>
    <?php
	    include "dbconn.php";
	
	$sql  = "SELECT email,broj_teme,naziv_teme FROM teme";
	$a=mysqli_query($dbc,$sql);
	while($ro=mysqli_fetch_array($a)){
		$tema=new Tema($ro["naziv_teme"]);
		$tema->setKorisnik($ro["email"]);
		$tema->setBroj($ro["broj_teme"]);
		$tema->ispisiTrenutneTeme();
	}
	mysqli_close($dbc);
	/*
    	<li><a href="#" onClick="displaySubtopics()">Topic 1</a></li>
    	<li><a href="#" onClick="displaySubtopics()">Topic 2</a></li>
    	<li><a href="#" onClick="displaySubtopics()">Topic3</a></li>
	*/
	?>
    </ul>
    <input type="button" value="Hide topics" onClick="hideTopics()">
	
	</div>

    <div id="podteme">
		<h2>SubTopic: Topic number</h2>
		<?php 
		
		include "dbconn.php";
	$naziv=$tema->getNazivTeme();
	$sql  = "SELECT korisnik,brojpodteme,nazivpodteme,nazivteme FROM podteme WHERE nazivteme='$naziv'";
	$a=mysqli_query($dbc,$sql);
	while($ro=mysqli_fetch_array($a)){
		$podtema=new Podtema($ro["nazivpodteme"]);
		$podtema->setKorisnik($ro["korisnik"]);
		$podtema->setTema($ro["nazivteme"]);
		$podtema->ispis();
	}
	mysqli_close($dbc);
		
		
		?>
		<ul>
	    <li><a href="#">Subtopic 1</a></li>
    	<li><a href="#">SubTopic 2</a></li>
    	<li><a href="#">SubTopic3</a></li>
			
		</ul>
		<input type="button" value="Hide subtopics" onClick="hideSubtopics()">
	</div>

</div>
</section>
</div>


<footer>
<p id="datum"></p>
</footer>

</body>
</html>