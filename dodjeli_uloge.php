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
<h2>Set the role of one user:</h2>
<form action="dodjeli_uloge.php" method="post">
<label>Email of the user which you want so set his role:</label><input type="email" autocomplete="off" name="email">
<select name="selektiraj">
<option value="Administrator">Administrator</option>
<option value="Korisnik">Korisnik</option>
<option value="Banovani korisnik">Banovani korisnik</option>
</select>
<input type="submit" value="Set_role"/>
<?php
include("dbconn.php");
$email=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['email'])));
if($email!=''){
	
		$selektiraj=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['selektiraj'])));
		$qv="INSERT INTO uloge (email,uloga) VALUES ('$email','$selektiraj')";
		if($qv){
			echo "Succesfully entered";
		}else{
			echo "fail";
		}
		mysqli_query($dbc,$qv);
		mysqli_close($dbc);
		
	}


?>
</form>
</section>
</div>

</body>
</html>