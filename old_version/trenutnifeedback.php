<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>

<div class="con">
<nav>

<a href="index.html" target="_blank">Back to main page</a>
<a href="privacy.php" target="_blank">Terms of privacy</a>

</nav>
</div>
<div class="pravila">
<section><h2>Feedbackovi</h2>
<table>
<?php
include('dbconn.php');
/* stara verzija
$query="SELECT firstname,lastname,suggestion FROM kvaliteta";
$q=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($q)){
	echo"<tr>";
	echo"<td>".$row['firstname']."&ensp;".$row['lastname']."&ensp;".$row['suggestion']."</td>";
	echo "</tr>";
};
mysqli_close($dbc);
*/
$query="SELECT * FROM kvaliteta";
$q=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($q)){
	echo"<tr>";
	echo"<td>".$row['id']."&ensp;".$row['firstname']."&ensp;".$row['lastname']."&ensp;".$row['suggestion']."<br/> <input type='checkbox' name='obavljeno' value='Obavljeno?'/><label>Obavljeno?</label></td>";
	echo "</tr>";
};
mysqli_close($dbc);
?>
</table>
</section>
</div>



</body>
</html>