<?php



function query(int $limit){
	return "SELECT type_of_gallery,imageType,imageData FROM galerija LIMIT $limit";
}
function queryWithoutLimit(){
	return "SELECT type_of_gallery,imageType,imageData FROM galerija";
}
function queryCategory(int $limit,string $category){
	return "SELECT type_of_gallery,imageType,imageData FROM galerija  WHERE type_of_gallery = '$category' LIMIT $limit";
}
function queryCategoryWithNoLimit(string $category){
	return "SELECT type_of_gallery,imageType,imageData FROM galerija  WHERE type_of_gallery='$category'";
}
function queryItems(){
	return "SELECT imageId FROM galerija";
}
function selectRange(int $limit,string $category,int $first, int $second){
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