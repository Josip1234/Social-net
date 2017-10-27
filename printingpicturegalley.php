


<!doctype html>
<html>
<head>


<meta charset="utf-8">
<title>Untitled Document</title>

<link href="css/forma.css" rel="stylesheet" type="text/css">
</head>

<body>
   
   <form id="forma" method="post" action="printingpicturegalley.php">
    <label>Number of pictures you want to print:</label><br>
    <input type="number" name="limit"><br>
    <label>Width of image in %:</label><br>
    <input type="number" name="width" required><br>
    <label>Height of image in %:</label><br>
    <input type="number" name="height" required><br>
    <label>Print pictures by categories:</label><br>
    <input type="text" name="category"><br>
	<input type="submit" value="choose">
</form>

<?php
	if($_SERVER['REQUEST_METHOD']=="GET"){
	include("dbconn.php");
	include("functions.php");
		$limit=$_GET['limit'];
	$category=$_GET['category'];
		
		$first=$_GET['first'];
		$second=$_GET['second'];
		
	/*$limit=$_POST['limit'];*/
	/*$width=$_POST['width'];
	$height=$_POST['height'];*/
	//$limit=6;
	$width=40;
	$height=40;
	//$category=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['category'])));
	
	
   // if($limit!="" && $category==""){
	//$query=query($limit);
	//}else if($limit=="" && $category==""){
	//	$query=queryWithoutLimit();
	//}else if($limit!="" && $category!=""){
		//$query=queryCategory($limit,$category);
	//}else{
	//	$query=queryCategoryWithNoLimit($category);
	//}
		
		$query=selectRange($limit,$category,$first,$second);
	$a=mysqli_query($dbc,$query);
	
	echo "<p>";
	while($row=mysqli_fetch_array($a)){
	    $id=$row['imageId'];
		
		/*echo $row['imageId']." ".$row['type_of_gallery'];*/
		
		
		echo '<img src="data:'.$row['imageType'].';base64,'.base64_encode( $row['imageData'] ).'"   width="'.$width.'%" height="'.$height.'%" />';
		
		
	}
		echo "</p>";
	mysqli_close($dbc);
	
	
	
	}
	//echo getNumberOfItemsInDatabase();
	?>
	
</body>
</html>