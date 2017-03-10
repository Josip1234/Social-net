
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
<a href="#" target="_blank">Login</a>
<a href="privacy.php" target="_blank">Terms of privacy</a>
<a href="profile.php" target="_blank">Profile of user</a>

</nav>
</div>
<div class="pravila">
<section><h2>Register here</h2>
<form action="registration.php" method="post">
<label>First name:</label><br/>
<input type="text" name="fname" autocomplete="off" maxlength="50" size="17" required/><br/>
<label>Last name:</label><br/>
<input type="text" name="lname" autocomplete="off" maxlength="50" size="17" required/><br/>
<label id="r">Sex:</label><br/>

<input type="radio"  id="radb" name="spol" value="muski" required>M 
<input type="radio"   id="radb" name="spol" value="zenski" required>Z 

<br/>
<label>Date of birth:</label><br/>
<input type="date" name="datum_rodjenja" required/><br/>
<label>City of birth:</label><br/>
<input type="text" name="city_of_birth" maxlength="50" size="17" autocomplete="off" required/><br/>
<label>Country of birth:</label><br/>
<input type="text" name="country_of_birth" maxlength="50" size="17" autocomplete="off" required /><br/>
<label>Pass:</label><br/>
<input type="password" name="pass" maxlength="50" size="17" required autocomplete="off" /><br/>

<br/>
<label>Email:</label><br/>
<input type="email" name="email" required maxlength="50" size="17" autocomplete="off"/><br/>
<input type="submit" value="Register"/>

</form>
<?php
include('dbconn.php');

$firstname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
if($firstname!=''){
	$lastname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
	if($lastname!=''){
		$sex=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['spol'])));
		if($sex!=''){
			$datum_rodjenja=$_POST['datum_rodjenja'];
			if($datum_rodjenja!=''){
				$city=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['city_of_birth'])));
				if($city!=''){
					$country=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['country_of_birth'])));
					if($country!=''){
						$pass=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['pass'])));
						if($pass!=''){
							
								$email=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['email'])));
								if($email!=''){
								$query="INSERT INTO registration(fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email) VALUES ('$firstname','$lastname','$sex','$datum_rodjenja','$city','$country','$pass','$email')";
mysqli_query($dbc,$query);
mysqli_close($dbc);
if($query){
	
	header('Location:login.php');
}else{
	die('Error! Connot add informations!');
}
								
							}
						}
					}
				}
			}
		}
	}
}
?>
</section>
</div>



</body>
</html>