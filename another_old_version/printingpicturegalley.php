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
<title>Picture gallery</title>
<script type="text/javascript" src="/mreza/Social-net/galerija.js"></script>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<script  src="js/drustvenijs.js" type="text/javascript"></script>
<script language="JavaScript" src="js/calendar.js" type="application/javascript"></script>
<script src="js/dropdownmenu.js" type="application/javascript"></script>
<script src="js/randomslike.js" type="application/javascript"></script>
</head>

<body onMouseOver="prikazi_datum(),dohvati_kalendar()" onLoad="getSLike(),slike()">
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
<a href="forum.php" target="_self">Forum</a>

</nav>

</div>

<ul id="f1">
<li><a href="#" onMouseOver="openmenu('m1')" onMouseOut="menuclosetime()">Opcije profila</a>
<div id="m1" onMouseOver="menucanceltime()" onMouseOut="menuclosetime()">
<a href="terminirajprofil.php" target="_self">Delete profile</a>
<a href="profilna.php" target="_self">Add profile picture</a>
<a href="updateprofilne.php" target="_self">Update profile picture</a>
<a href="Galerija.html" target="_self">Picture gallery</a>
<a href="addtogallery.php" target="_self">Add to gallery</a>

</div>
</li>
</ul>
<div style="clear:both"></div>
<section id="cal">
<h2>Calendar for March 2017</h2>
<p id="calendar"></p>

</section>
<section id="randslike">
<h2>Random slike</h2>
<p id="s"></p>

</section>
<section id="valut">
	<iframe src="Pretvorba valuta/valuta.html" seamless></iframe>
</section>	


<div class="pravila">
<section><h2>Picture Gallery</h2>

   <div id="forma">
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
	</div>


</section>
<section><h2>Content:</h2>

	<div id="sadrzaj">
<?php
	if($_SERVER['REQUEST_METHOD']=="POST"){
	include("dbconn.php");
	include("functions.php");
		$pokusaj=0;
		$limit=$_GET['limit'];
	$category=$_GET['category'];
		
		$first=$_GET['first'];
		$second=$_GET['second'];
		
	$limit=$_POST['limit'];
	$width=$_POST['width'];
	$height=$_POST['height'];
	//$limit=6;
	$width=40;
	$height=40;
	$category=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['category'])));
	
	
    if($limit!="" && $category==""){
	$query=query($limit);
	}else if($limit=="" && $category==""){
		$query=queryWithoutLimit();
	}else if($limit!="" && $category!=""){
		$query=queryCategory($limit,$category);
	}else{
		$query=queryCategoryWithNoLimit($category);
	}
		
	//	$query=selectRange($limit,$category,$first,$second);
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
	</div>


</section>
</div>


<footer>
<p id="datum"></p>
<nav>
	<a href="animals.html">Animal Picture Gallery</a>
	<a href="people.html">People Picture Gallery</a>
	<a href="photoshopped.html">Photoshopped Gallery</a>
	<a href="cars.html">Car gallery</a>
</nav>

</footer>



</body>
</html>