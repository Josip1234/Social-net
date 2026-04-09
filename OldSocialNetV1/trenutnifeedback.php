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

<?php include "navigacija.php"; ?>

</nav>
</div>
<div class="pravila">
<section><h2>Feedbackovi</h2>
<table>
<?php
include('functions.php');
$query="SELECT id,firstname,lastname,suggestion FROM kvaliteta";
$q=mysqli_query($dbc,$query);
echo "<table border='1'><thead><tr><th>Broj feedbacka</th>
	<th>Ime i prezime</th>
	<th>Feedback</th>
	</tr></thead><tbody>";
while($row=mysqli_fetch_array($q)){
	
	echo"<tr>";
	echo"<td>{$row['id']}</td>";
	echo "<td>{$row['firstname']} {$row['lastname']}</td>";
	echo "<td>{$row['suggestion']}</td>";
	echo "</tr>";
};
echo "</tbody></table>";
mysqli_close($dbc);
	
?>
</table>
</section>
</div>



</body>
</html>