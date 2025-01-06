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
<section><h2>Register here</h2>
<form action="registration.php" method="post">
<label>First name:</label><br/>
<input type="text" name="fname" autocomplete="off" maxlength="50" size="17" required/><br/>
<label>Last name:</label><br/>
<input type="text" name="lname" autocomplete="off" maxlength="50" size="17" required/><br/>
<label>Sex:</label><br/>
<input type="radio" name="spol" value="muski" required>M 
<input type="radio" name="spol" value="zenski" required>Z 
<br/>
<label>Date of birth:</label><br/>
<input type="date" name="datum_rodjenja" required/><br/>
<label>City of birth:</label><br/>
<input type="text" name="city_of_birth" maxlength="50" size="17" autocomplete="off"/><br/>
<label>Country of birth:</label><br/>
<input type="text" name="country_of_birth" maxlength="50" size="17" autocomplete="off" /><br/>
<label>Pass:</label><br/>
<input type="password" name="pass" maxlength="50" size="17" required autocomplete="off" /><br/>
<label>Profile picture:</label><br/>
<input type="file" name="slika"><br/> 
<br/>
<input type="submit" value="Register"/>
</form>
</section>
</div>



</body>
</html>