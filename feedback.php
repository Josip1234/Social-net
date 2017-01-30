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
<input type="text" name="fname"/><br/>
<label>Your last name:</label><br/>
<input type="text" name="lname"/><br/>
<label>Suggestions of improvment:</label><br/>
<textarea name="suggestions"></textarea>
<br/>

<input type="submit" value="Send suggestion"/>
</form>
<?php
include("dbconn.php");
$fname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
$lname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
$suggestions=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['suggestions'])));
$query="INSERT INTO kvaliteta (firstname,lastname,suggestion) VALUES ('$fname','$lname','$suggestions')";
mysqli_query($dbc,$query);
mysqli_close($dbc);
?>
</section>
</div>



</body>
</html>
