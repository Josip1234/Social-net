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

<a href="#" target="_blank">Registation</a>
<a href="#" target="_blank">Login</a>

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
	die("Thanks for adding some suggestions");
}else{
	die("Error! Information not inserted!");
}
}
}
}else{
	die("Can 't add empty informations");
}
?>
</section>
</div>



</body>
</html>
