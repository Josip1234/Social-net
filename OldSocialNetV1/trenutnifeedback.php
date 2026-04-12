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
$formAction=htmlspecialchars($_SERVER["PHP_SELF"]);
$query="SELECT id,firstname,lastname,suggestion FROM kvaliteta";
$q=mysqli_query($dbc,$query);
echo "<table border='1'><thead><tr><th>Broj feedbacka</th>
	<th>Ime i prezime</th>
	<th>Feedback</th>
	<th>Actions</th>
	</tr></thead><tbody>";
while($row=mysqli_fetch_array($q)){
	
	echo"<tr>";
	echo"<td>{$row['id']}</td>";
	
	echo "<td>{$row['firstname']} {$row['lastname']}</td>";
	echo "<td>{$row['suggestion']}</td>";
	echo "<td>"."<form action='{$formAction}' method='post'>
	<input type='hidden' name='id' value='{$row['id']}'>
	<input type='checkbox' name='done' id='done' value='1'>Done?
	<button type='submit'>Send</button>
	</form>"."</td>";
	echo "</tr>";
};
echo "</tbody></table>";
mysqli_close($dbc);
	if($_SERVER["REQUEST_METHOD"]==="POST"){
		if(isset($_POST["done"])){
			$done=$_POST["done"];
		}else{
			$done=0;
		}
		$id=$_POST["id"];
		echo $done;
		echo $id;
	}
?>

</table>
</section>
</div>



</body>
</html>