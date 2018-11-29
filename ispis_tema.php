<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ispis_tema</title>
<script src="/mreza/Social-net/js/ajax.js" type="application/javascript"></script>
</head>

<body>


<?php
	include("dbconn.php");
    echo "
	<table>
	<tr>

<th>Naziv teme</th>	
</tr>
	

	";
	$sql="SELECT id,email,naziv_teme FROM teme";
	$query=mysqli_query($dbc,$sql);
	while($a=mysqli_fetch_array($query)){
		echo "<tr>";
		echo "<td>".$a['naziv_teme']."</td>";
		echo "</tr>";
	}
	echo "</table>";
	
	
	?>
	
	<div id="txt"></p>
</body>
</html>