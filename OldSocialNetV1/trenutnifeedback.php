
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<script src="socialnet.js"></script>
<script src="calendar.js"></script>
</head>

<?php include "functions.php"; echo printBodyOnMouseOver(); ?>

<div class="con">
<nav>

<?php require_once "navigacija.php"; 
require_once "dbconn.php";
loggedUsersOnly();
?>

</nav>
</div>
<?php echo printCalendar(); ?>
<div class="pravila">
<section><h2>Feedbackovi</h2>
<table>
<?php

$formAction=htmlspecialchars($_SERVER["PHP_SELF"]);
//this query will take only suggestions which has noot been solved.
$query="SELECT k.id,k.firstname,k.lastname,k.suggestion FROM kvaliteta k
left join obavljeno o on k.id=o.kvaliteta_id where o.obavljeno is null";
$q=mysqli_query($dbc,$query);
$numberOfRows=mysqli_num_rows($q);
if($numberOfRows>0){
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
}else{
	echo "There are no suggestions left. Everything has been solved.";
}

	if($_SERVER["REQUEST_METHOD"]==="POST"){
		if(isset($_POST["done"])){
			$done=$_POST["done"];
		}else{
			$done=0;
		}
		if($done!=0){
		$id=$_POST["id"];
		$sql="INSERT INTO obavljeno (obavljeno, kvaliteta_id) values ('$done','$id')";
		mysqli_query($dbc,$sql);
		if($query){
			$msg="Successfully solved suggestion.";
			mysqli_close($dbc);
			header('Location: trenutnifeedback.php?msg='.$msg);
		}
		}else{
			echo "There is nothing to insert.";
		}

	}
?>

</table>
</section>
</div>


<?php 
echo printFooter();
?>
</body>
</html>