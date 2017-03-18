<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location:login.php');
}else{
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
</head>

<body>

<div class="con">
<nav>

<a href="#" target="_self">Registation</a>
<a href="#" target="_self">Login</a>
<a href="profile.php" target="_self">Profile of user</a>
<a href="logout.php" target="_self">Logout</a>

</nav>
</div>
<div class="pravila">
<section><h2>Update your profile picture here</h2>
<?php
include('dbconn.php');
	
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {

$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
$sql = "INSERT INTO profilna(imageType ,imageData)
VALUES('{$imageProperties['mime']}', '{$imgData}')";
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
