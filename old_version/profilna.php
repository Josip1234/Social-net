<?php 
include "dbconn.php";
session_start();
if(!isset($_SESSION['username'])){
	header('Location: registration.php');
}else{
	if($_SESSION['role']!="Administrator"){
		//header('Location: profile.php');
		$_SESSION['login']=time();
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
<a href="profile.php" target="_blank" rel="noopener noreferrer">Profile of user</a>
<a href="logout.php" target="_blank" rel="noopener noreferrer">Logout</a>
<a href="privacy.php" target="_blank" rel="noopener noreferrer">Terms of privacy</a>
<?php 

if($_SESSION['role']=="Administrator"){
echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>User roles</a>";
echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer'>Feedbacks</a>";
}
?>
<a href="feedback.php" target="_blank" rel="noopener noreferrer">Add feedback</a>
<a href="terminirajprofil.php" target="_blank" rel="noopener noreferrer">Delete profile</a>
<a href="profilna.php" target="_blank" rel="noopener noreferrer">Add profile picture</a>
<a href="update_profilne.php" target="_blank" rel="noopener noreferrer">Update profile picture</a>
</nav>
</div>
<div class="pravila">
<section><h2>Set your profile picture here</h2>
<?php

if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$username=$_SESSION['username'];
$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
$sql = "INSERT INTO profilna(imageType ,imageData, email)
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



</body>
</html>