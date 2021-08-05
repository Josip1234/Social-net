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

 <!--   <div class="dodjela_uloga">
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
        <input type="submit" value="Set_role"> -->
        <?php /*
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
*/

?>
    <div class="pravila">
    <section>
        <h2>Set the role of one user:</h2>
        <label>Email of the user which you want so set his role:</label><input type="email"  name="user"autocomplete="off" required /><br/>
<label>User role:</label><input type="text" name="s" value="Administrator,korisnik ili banovani korisnik" required/>
        <input type="submit" value="Set_role">
        </form>
        <?php 
                 include("dbconn.php");
                 $email=$_POST['user'];
                 $s=$_POST['s'];
                 if($email!=''){
                     if($s!=''){
                         if($s=="Administrator"){}else
                         if($s=="Korisnik"){}else{}
                         if($s=="Banovani korisnik"){}else
                         {die("Invalid role");};

                     }else{
                         die("Missing role");
                     }
                 }else{
                     die("Email missing");
                 }
        ?>
    </section> 
    </div>
        </form>
    </section> 
    </div>
    
</body>

</html>