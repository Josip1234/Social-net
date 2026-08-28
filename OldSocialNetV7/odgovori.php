<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Odgovori na teme</title>
</head>

<body>
<?php
	include("dbconn.php");

	$sql="SELECT email,datum_i_vrijeme_komentara,komentar FROM komentari";
	$result=mysqli_query($dbc,$sql);
	echo "<table>
	<tr>
	<th>Email</th>
	<th>Date and time</th>
	<th>Comment</th>
	
	</tr>";
	while($row=mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$row['email']."</td>";
		echo "<td>".$row['datum_i_vrijeme_komentara']."</td>";
		echo "<td>".$row['komentar']."</td>";

		echo "</tr>";
		
		
	}
	mysqli_close($dbc);
?>
</body>
</html>