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
<script language="JavaScript" src="js/drustvenijs.js" type="application/javascript"></script>
<script language="JavaScript" src="js/calendar.js" type="application/javascript"></script>
<script src="js/dropdownmenu.js" type="application/javascript"></script>
<script src="js/randomslike.js" type="application/javascript"></script>

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
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<a href="Galerija.html" target="_self">Picture gallery</a><a href="addtogallery.php" target="_self">Add to gallery</a>

=======
>>>>>>> parent of ad58c11... napravljene galerije
=======
>>>>>>> parent of ad58c11... napravljene galerije
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
<div class="pravila">
<section><h2>Set your profile picture here</h2>
<?php
include('dbconn.php');
$upit="SELECT imageId,imageType,imageData, email FROM profilna WHERE email='$username'";
$a=mysqli_query($dbc,$upit);
if(mysqli_num_rows($a)>0){
	echo "You cant add new profile picture you already have one. Go to update profile to change it!";
}else{
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {

$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);


$sql = "INSERT INTO profilna(imageType ,imageData,email)
VALUES('{$imageProperties['mime']}', '{$imgData}','$username')";
mysqli_query($dbc,$sql);

mysqli_close($dbc);

}}
}
?>
<form name="frmImage" enctype="multipart/form-data" action="profilna.php" method="post" class="frmImageUpload">
<label>Upload Image File:</label><br/>
<input name="userImage" type="file" class="inputFile" />
<input type="submit" value="Submit" class="btnSubmit" />
</form>
</div>


<footer>
<p id="datum"></p>
</footer>
</body>
</html>
