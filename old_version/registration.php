<?php 
include "dbconn.php";
session_start();
if(!isset($_SESSION['username'])){
	
}else{
	if($_SESSION['role']!="Administrator"){
		header('Location: profile.php');
	}else{
		$_SESSION['login']=time();
	}
	
}

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/dropdown.css">
    <script src="js/social.js"></script>
    <script src="js/calendar.js"></script>
    <script src="js/random.js"></script>
<script src="js/dropdownmenu.js"></script>
</head>

<body onmouseover="prikazi_datum(), dohvati_kalendar_nova_verzija()" onload="slike()">

<div class="con">
<nav>
<div class="dropdown">
    <button class="dropbtn">Profil</button>
    <div class="dropdown-content">
        <a href="registration.php">Registation</a>
        <a href="profile.php">Profile of user</a>
        <a href="terminirajprofil.php">Delete profile</a>
<a href="profilna.php" style="font-size: 10px;">Add profile picture</a>
<a href="update_profilne.php" style="font-size: 10px;">Update profile picture</a>
<a href="login.php" target="_blank">Login</a>
<a href="logout.php" target="_blank">Logout</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Privacy, feedbacks</button>
    <div class="dropdown-content">
        <a href="privacy.php" target="_blank" style="font-size: 12px;">Terms of privacy</a>
         
        <a href="feedback.php" target="_blank">Add feedback</a>
        <?php 
        if($_SESSION['role']=="Administrator"){
            echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer' style='font-size: 10px;'>Trenutni feedbackovi</a>";
        };?>
    </div>
  </div>
    <?php
    if($_SESSION['role']=="Administrator"){
        echo "<div class='dropdown'>";
        echo "<button class='dropbtn'>Admin options</button>";
        echo "<div class='dropdown-content'>";
        echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>Set user roles</a>";
        echo "<a href='update_roles_for_all.php' target='_blank' rel='noopener noreferrer'>Update all roles</a>";    
        echo "</div>";
     echo "</div>";

}
?>
  <div class="dropdown">
    <button class="dropbtn">Forumi,chatovi, početna</button>
    <div class="dropdown-content">
    <a href="forum.php" target="_blank" rel="noopener noreferrer">Forum</a>
    <a href="index.html" target="_blank" rel="noopener noreferrer">Back to home page</a>
    </div>
  </div>
</nav>
</div>
<section id="cal" class="cl">
        <h2>Calendar for March 2025</h2>
        <p id="calendar"></p>
    </section>
	<section id="randslike">
<h2>Random slike</h2>
<p id="s"></p>
    </section>
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
<input type="text" name="city_of_birth" maxlength="50" size="17" autocomplete="off" required/><br/>
<label>Country of birth:</label><br/>
<input type="text" name="country_of_birth" maxlength="50" size="17" autocomplete="off" required /><br/>
<label>Pass:</label><br/>
<input type="password" name="pass" maxlength="50" size="17" required autocomplete="off" /><br/>

<label>Email:</label><br/>
<input type="email" name="email" required maxlength="50" size="17" autocomplete="off"/><br/>
<input type="submit" value="Register"/>

</form>
<?php
include('dbconn.php');
$default_role="Korisnik";
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
//provjeri dali je korisnik unesen u bazu, zatim unesi u tablicu dodjeli uloge defaultnu ulogu korisnika kao korisnik definiran u varijabli $korisnik
          
									
									
									if($query){
										$insert_into_dodjela_uloga="INSERT INTO uloge(email,uloga) VALUES ('$email','$default_role')";
									mysqli_query($dbc,$insert_into_dodjela_uloga);
									mysqli_close($dbc);
										header('Location:login.php');
										
									}else{
										die('Error! Connot add informations!');
										mysqli_close($dbc);
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

<footer>
	<p id="datum"></p>
</footer>

</body>
</html>
