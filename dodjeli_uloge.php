<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
if($_SESSION['role']!='Administrator'){
    header('Location: profile.php');
}else{
    $_SESSION['login']=time();
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
</head>
<body>
<div class="con">
<nav>
    <a href="registration.php" target="_self">Registration</a>
    <a href="login.php" target="_self">Login</a>
    <a href="trenutnifeedback.php" target="_self">Feedbacks-only for admins</a>
    <a href="profile.php" target="_self">Profile of user</a>
    <a href="logout.php" target="_self">Logout</a>
</nav>        
    </div>
<div class="pravila">
<section>
<?php
include('dbconn.php');
$sql="SELECT id, fname, lname, sex, dateofbirth, cityofbirth, countryofbirth, pass, email FROM registration";
$result=mysqli_query($dbc,$sql);
while($res=mysqli_fetch_array($result)){
echo $res['id']."<br>";
echo $res['fname']."<br>";
echo $res['lname']."<br>";
echo $res['sex']."<br>";
echo $res['dateofbirth']."<br>";
echo $res['cityofbirth']."<br>";
echo $res['countryofbirth']."<br>";
echo $res['pass']."<br>";
echo $res['email']."<br><br>";

};
mysqli_close($dbc);
?>
</section>

</div>
    <div id="dodjela_uloga">
    <section>
        <h2>Set the role of one user:</h2>
        <form action="dodjeli_uloge.php" method="post">
        <label>Email of the user which you want to set his role:</label>
        <input type="email" name="email" autocomplete="off">
        <select name="selektiraj">
           <option value="Administrator">Administrator</option>
           <option value="Korisnik">Korisnik</option>
           <option value="Banovani korisnik">Banovani korisnik</option>            
        </select>
        <input type="submit" value="Set_role">
        <?php
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