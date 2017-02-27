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

<a href="#" target="_blank">Registation</a>
<a href="#" target="_blank">Login</a>

</nav>
</div>
<div class="pravila">
<section>
<?php
//napomena: bolje je rješenje izlistati jedan po jedan račun. 
include("dbconn.php");


$sql="SELECT id,fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email FROM registration";
$result=mysqli_query($dbc,$sql);
while($res=mysqli_fetch_array($result)){
	echo $res[id]."<br/>";
	
	echo $res['fname']."<br/>";
	echo $res['lname']."<br/>";
	echo $res['sex']."<br/>";
	echo $res['dateofbirth']."<br/>";
	echo $res['cityofbirth']."<br/>";
	echo $res['countryofbirth']."<br/>";
	echo $res['pass']."<br/>";
	echo $res['email']."<br/>";
	
	
	echo "<br/>";
	
}
mysqli_close($dbc);
?>
</section>
</div>

<div id="dodjela_uloga">
<section>
<h2>Dodjeli ulogu:</h2>
<form action="dodjeli_uloge.php" method="post">
<label>Email korisnika za kojeg želiš dodjeliti ulogu:</label><input type="email" autocomplete="off" name="email">
<select name="selektiraj">
<option>Administrator</option>
<option>Korisnik</option>
<option>Banovani korisnik</option>
</select>
<input type="submit" value="Set_role"/>
</form>
</section>
</div>

</body>
</html>
