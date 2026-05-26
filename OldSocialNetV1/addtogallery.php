<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Social net old first version</title>
<?php include "functions.php"; echo cssIncludes(); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php  echo jsIncludes(); ?>
</head>

<?php  echo printBodyOnMouseOverAndOnLoad(); ?>
    <div class="con">
        <nav>
          <?php include "navigacija.php"; ?>
        </nav>

    </div>
    <?php
    echo dropdownMenu();
    echo printCalendar();
echo printPictures();
echo printVideos();
echo printCurrencyRate();
?>
    <div class="pravila">
        <?php 
        if($_SERVER["REQUEST_METHOD"]==="POST"){
        	$date=getdate();
	$day=$date['mday'];
	
	$month=$date['mon'];

	$year=$date['year'];
	$currentdate=$day.".".$month.".".$year;
	

	$user=$_SESSION['username'];

	$type=isset($_POST['type'])?$_POST['type']:"";
        
    $date=date("Y-m-d",strtotime($currentdate));
    
   

    if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {

$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);

$sql="INSERT INTO `galerija` (email, date_of_upload, type_of_gallery, imageType ,imageData) VALUES ('$user', '$date', '$type', '{$imageProperties['mime']}', '{$imgData}')";
        
mysqli_query($dbc,$sql);

mysqli_close($dbc);
}};
        };
        ?>
        <form name="frmImage" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="frmImageUpload">
<label for="type">Upload Image File:</label><br/>
<select name="type" id="type">
	<option value="rest">Rest</option>
	<option value="animal">Animal</option>
	<option value="femalemodels">Female Models</option>
	<option value="femaleactress">Female Actress</option>
	<option value="femalesingers">Female Singers</option>
	<option value="animatedpeople">Animated People</option>
	<option value="femaledancers">Female Dancers</option>
	<option value="photoshopped">Photoshopped stuff</option>
	<option value="supercars">Supercars</option>
	<option value="sportcars">Sportcars</option>
	
</select>
<input name="userImage" type="file" class="inputFile" />
<input type="submit" value="Submit" class="btnSubmit" />
</form>
    </div>
    <?php 
echo printFooter();
?>
</body>
</html>