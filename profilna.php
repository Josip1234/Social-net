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
</head>

<body onMouseOver="prikazi_datum(),dohvati_kalendar()">

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

</nav>
</div>
<ul>
<li><a href="terminirajprofil.php" target="_self">Delete profile</a></li>
<li><a href="profilna.php" target="_self">Add profile picture</a></li>
<li><a href="updateprofilne.php" target="_self">Update profile picture</a></li>
</ul>
<section id="cal">
<h2>Calendar for March 2017</h2>
<p id="calendar"></p>

</section>
<div class="pravila">
<section><h2>Set your profile picture here</h2>
<?php
include('dbconn.php');
	
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {

$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);


$sql = "INSERT INTO profilna(imageType ,imageData,email)
VALUES('{$imageProperties['mime']}', '{$imgData}','$username')";
mysqli_query($dbc,$sql);

mysqli_close($dbc);

}}
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
