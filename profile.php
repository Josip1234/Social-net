<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location:login_system/login.php');
}else{
    $username=$_SESSION['username'];
	$_SESSION['login']=time();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/social.css" media="all">
    <title>Profile</title>
</head>
<body>
<body>

<div class="con">
<nav>

<a href="login_system/registration.php" target="_blank">Registation</a>
<a href="login_system/login.php" target="_blank">Login</a>
<a href="home.html">Back to main page</a>
<a href="login_system/logout.php" target="_blank">Logout</a>

</nav>
</div>
<div class="pravila">
<section><h2>Update your profile picture here</h2>
<?php
include('database/social_database_connection.php');
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
$sql = "INSERT INTO profile(imageType ,imageData,email)
VALUES('{$imageProperties['mime']}', '{$imgData}','$username')";
mysqli_query($dbc,$sql);


}}
?>
<form name="frmImage" enctype="multipart/form-data" action="profile.php" method="post" class="frmImageUpload">
<label>Upload Image File:</label><br/>
<input name="userImage" type="file" class="inputFile" />
<input type="submit" value="Submit" class="btnSubmit" />
</form>

<div class="pravila">
<section><h2>Your profile</h2>

<?php

$sql="SELECT imageId,imageType,imageData FROM profile WHERE email = '$username'";
$res=mysqli_query($dbc,$sql);
while($ro=mysqli_fetch_array($res)){
	
	echo '<img src="data:'.$ro['imageType'].';base64,'.base64_encode( $ro['imageData'] ).'"width="100" height="100"/> ';

	
	
	
	
}
mysqli_close($dbc);
?>



</section>
</div>


</div>

</body>
</html>