<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ispis_tema</title>
</head>

<body>


<?php
	include("dbconn.php");
    echo "
	<table>
	<tr>
<th><b>Broj teme</b></th>
<th>Naziv teme</th>	
</tr>
	

	";
	$sql="SELECT id,email,naziv_teme FROM teme";
	$query=mysqli_query($dbc,$sql);
	while($a=mysqli_fetch_array($query)){
		echo "<tr>";
		echo "<td>".$a[id]."</td><td>".$a['naziv_teme']."</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	
	?>
</body>
</html>