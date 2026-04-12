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
<section>
<?php
include "functions.php";
$sql="select r.id,r.email,u.id as rid,u.uloga from registration r left join uloge u on r.id=u.user_id;";
$q=mysqli_query($dbc,$sql);
echo "<table border='1'><thead><tr><th>User id</th>
	<th>User email</th>
	<th>Role id</th>
    <th>Role name</th>
	</tr></thead><tbody>";
while($row=mysqli_fetch_array($q)){
	
	echo"<tr>";
	echo"<td>{$row['id']}</td>";
	echo "<td>{$row['email']}</td>";
	echo "<td>{$row['rid']}</td>";
    echo "<td>{$row['uloga']}</td>";
	echo "</tr>";
};
echo "</tbody></table>";
mysqli_close($dbc);
?>
</section>
</div>



</body>
</html>