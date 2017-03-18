<!doctype html>
<html>
<head>

<meta charset="UTF-8" />
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
<section>
<h2>Your feedback</h2>
<form action="feedback.php" method="post">
<label>Your first name:</label><br/>
<input type="text" name="fname" required autocomplete="off"/><br/>
<label>Your last name:</label><br/>
<input type="text" name="lname" required autocomplete="off"/><br/>
<label>Suggestions of improvment:</label><br/>
<textarea name="suggestions" required></textarea>
<br/>

<input type="submit" value="Send suggestion"/>
</form>
<label>
<?php
include("dbconn.php");


$fname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
//riješen problem dodavanja praznih redaka za fname, lname i suggestions
if($fname!=''){
	//strip_tags uklanjaju php i html oznake, trim uklanja nepotreban razmak ili druge znakove sa oba kraja stringa 
	//mysqli_real_escape sa ostalim objašnjenim funkcijama sprječavaju sql injekciju
$lname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
if($lname!=''){
$suggestions=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['suggestions'])));
if($suggestions!=''){
$query="INSERT INTO kvaliteta (firstname,lastname,suggestion) VALUES ('$fname','$lname','$suggestions')";
mysqli_query($dbc,$query);

mysqli_close($dbc);
include("functions.php");
if($query){
	header('Location:index.html');
	
}else{
	die("Error! Information not inserted!");
}
}
}
}else{
	die("Can 't add empty informations");
}
?>
</label>
</section>
</div>



</body>
</html>
