
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Socialnet</title>
<?php include "functions.php"; echo cssIncludes(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php  echo jsIncludes(); ?>
</head>

<?php  echo printBodyOnMouseOverAndOnLoad(); ?>

<div class="con">
<nav>

<?php require_once "navigacija.php";
require_once "dbconn.php";
loggedUsersOnly();


if(!isset($_GET["email"])){
   header('Location: registration.php');
}

?>

</nav>
</div>
<?php 
echo dropdownMenu();
echo printCalendar();
echo printPictures();
echo printVideos();

?>
<div class="pravila">
<section><h2>Set your profile picture here</h2>

	

<?php
if(checkIfThereIsAlreadyProfilePictureInDatabase($_SESSION["username"])===true){
   echo "Profile image already exists for this user!";
}else{
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$email=$_POST["email"];
$imageId=str_replace([" ","-",":"],"",date("Y-m-d H:i:s"));
$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
$sql = "INSERT INTO profilna(imageType ,imageData,email,imageId)
VALUES('{$imageProperties['mime']}', '{$imgData}', '$email','$imageId')";
mysqli_query($dbc,$sql);
mysqli_close($dbc);
if($sql){
	header('Location:index.php');
}
}}
}
if(checkIfThereIsAlreadyProfilePictureInDatabase($_SESSION["username"])!=true):
?>
<form name="frmImage" enctype="multipart/form-data" action="profilna.php" method="post" class="frmImageUpload">
<input type="hidden" name="email" value="<?= $_GET["email"]; ?>">
<label>Upload Image File:</label><br/>
<input name="userImage" type="file" class="inputFile" />
<input type="submit" value="Submit" class="btnSubmit" />
</form>
<?php endif; ?>
</div>


<?php 
echo printFooter();
?>
</body>
</html>