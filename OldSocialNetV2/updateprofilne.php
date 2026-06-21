<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location:login.php');
}else{

   $username=$_SESSION['username'];
	$_SESSION['login']=time();
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
<?php
include "dbconn.php";
$sql="SELECT imageId,imageType,imageData FROM profilna WHERE email = '$username'";
$res=mysqli_query($dbc,$sql);
while($ro=mysqli_fetch_array($res)){
	echo "<label>User image:</label><br/>";
	echo '<img src="data:'.$ro['imageType'].';base64,'.base64_encode( $ro['imageData'] ).'"/> ';
   
	
	
}
?>
<form name="frmImage1" enctype="multipart/form-data" action="updateprofilne.php" method="post" class="frmImageUpload">
<label>Upload Image File:</label><br/>
<input name="userImage2" type="file" class="inputFile" />
<input type="submit" value="Submit" class="btnSubmit" />
</form>
<?php

if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage2']['tmp_name'])) {
$imgData =addslashes(file_get_contents($_FILES['userImage2']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage2']['tmp_name']);


$sql = "UPDATE profilna SET email='$username',imageType='{$imageProperties['mime']}',imageData='{$imgData}' WHERE email='$username'";

if($t=mysqli_query($dbc,$sql)){
	echo "Update succesfull";

}

mysqli_close($dbc);

}}
?>
</section>
</div>

<footer>
<p id="datum"></p>
</footer>

</body>
</html>
