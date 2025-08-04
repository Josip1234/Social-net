<?php
function query($limit){
	return "SELECT type_of_gallery,imageType,imageData FROM galerija LIMIT $limit";
}
function queryWithoutLimit(){
	return "SELECT type_of_gallery,imageType,imageData FROM galerija";
}
function queryCategory($limit,$category){
	return "SELECT type_of_gallery,imageType,imageData FROM galerija  WHERE type_of_gallery = '$category' LIMIT $limit";
}
function queryCategoryWithNoLimit($category){
	return "SELECT type_of_gallery,imageType,imageData FROM galerija  WHERE type_of_gallery='$category'";
}
function queryItems(){
	return "SELECT imageId FROM galerija";
}
function selectRange($limit,$category,$first,$second){
	return "SELECT imageId,type_of_gallery,imageType,imageData  FROM galerija  WHERE type_of_gallery='$category' && imageId >=$first && imageId<=$second LIMIT $limit";
}
function getNumberOfItemsInDatabase(){
	include("dbconn.php");
	$items=0;
	$query=queryItems();
	$a=mysqli_query($dbc,$query);
	
	while($row=mysqli_fetch_array($a)){
	    $items+=1;
		
		
	}
		
	mysqli_close($dbc);
	return $items;
}
?>