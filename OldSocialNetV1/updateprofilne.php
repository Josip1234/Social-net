
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<?php include "functions.php"; echo jsIncludes(); ?>
</head>

<?php  echo printBodyOnMouseOverAndOnLoad(); ?>

<div class="con">
<nav>
<?php 
require_once "navigacija.php"; 
require_once "dbconn.php";
loggedUsersOnly();
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
   
<?php
$username=$_SESSION["username"];     



if($_SERVER["REQUEST_METHOD"]==="POST"){
	
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage2']['tmp_name'])) {

$imageId=str_replace([" ","-",":"],"",date("Y-m-d H:i:s"));
//if image id from database is different than new image id 
//and if file has been uploaded  
//update profile picture
if(!empty($_FILES['userImage2']['tmp_name'])){

$imgData =addslashes(file_get_contents($_FILES['userImage2']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage2']['tmp_name']); 

	//need this to store data in image history
	$_SESSION["file"]["imgData"]=$imgData;
	$_SESSION["file"]["imgProp"]=$imageProperties;


$sql ="UPDATE profilna SET email='$username',imageType='{$imageProperties['mime']}',imageData='{$imgData}',imageId='$imageId' WHERE email='$username'";
mysqli_query($dbc,$sql);


if($sql){
	mysqli_close($dbc);
	echo "Update successfull";
	echo "Do you want to save your previous profile picture?";

	echo "<form action='".htmlspecialchars('save_history.php')."' method='post'>
	<input type='checkbox' name='odgovor' id='yes' value='yes'>Yes 
	<br>
	<input type='checkbox' name='odgovor' id='no' value='no'>No 
	<input type='submit' value='Submit'>
</form>";
	//header("Location: profile.php");
}

}


}}
}
else{

$sql="SELECT imageId,imageType,imageData FROM profilna WHERE email = '$username'";
$res=mysqli_query($dbc,$sql);
while($ro=mysqli_fetch_array($res)){
	echo "<label>User image:</label><br/>";
	echo '<img src="data:'.$ro['imageType'].';base64,'.base64_encode( $ro['imageData'] ).'"/> ';
    
	$_SESSION["imageId"]=$ro['imageId'];
	$_SESSION["imageType"]=$ro['imageType'];
	$_SESSION["imageData"]=$ro['imageData'];
	
	
	
}
};
?>
<form name="frmImage1" enctype="multipart/form-data" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="frmImageUpload">
<label>Upload Image File:</label><br/>
<input name="userImage2" type="file" class="inputFile" />
<input type="submit" value="Submit" class="btnSubmit" />
</form>

</section>
</div>


<?php 
echo printFooter();
?>
</body>
</html>