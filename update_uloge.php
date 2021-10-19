<?php
include("dbconn.php");
session_start();
if(!isset($_SESSION['username'])){
    header('Location:login.php');
}else{
    if($_SESSION['role']!='Administrator'){
        header('Location: profile.php');
    }else{
        S_SESSION['login']=time();
    }
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Socialnet</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/stil.css" rel="stylesheet">
    </head>
    <body>
    <div class="con">
<nav>
    <a href="registration.php" target="_self">Registration</a>
    <a href="login.php" target="_self">Login</a>
    <a href="dodjela_uloga.php">Set user roles</a>
    <a href="feedback.php">Add feedback</a>
    <a href="profile.php">Go back to profile</a>

</nav>
    </div>
    <div class="pravila">
<section>
    <?php 
$e=$_SESSION['selektiraj'];
$upit="SELECT uloga FROM registration WHERE email='$e'";
$t=mysqli_query($dbc,$upit);
while($ro=mysqli_fetch_array($t)){
    if(mysqli_num_rows($ro)<2){
        $t=$ro['uloga'];
    }else{
die("Too many users select only one");
    }

    ?>
    <form action="update_uloge.php" method="post">
        <label for="uloga">Uloga:</label>
        <input type="text" name="uloga1" value="<?php  echo $ro['uloga']; };?>"> <br>
        <input type="submit" value="Update role">
        
    </form>
    <?php
$uloga1=$_POST['uloga1'];
if($_SERVER['REQUEST_METHOD']=='POST'){
	if($t!=$uloga1){
		$upit2="UPDATE registration SET uloga='$uloga1' WHERE email='$e'";
		$u=mysqli_query($dbc,$upit2);
		if($u){
			echo "Succesfully updated user role";
			$_SESSION['selektiraj']=session_unset();
		    $_SESSION['selektiraj']=session_destroy();
			mysqli_close($dbc);
	
		}else{
			echo "Update failed please try again";
			$_SESSION['selektiraj']=session_unset();
		    $_SESSION['selektiraj']=session_destroy();
			
		   
			mysqli_close($dbc);
		}
	}else{
		echo "Nothing changed";
		$_SESSION['selektiraj']=session_unset();
		$_SESSION['selektiraj']=session_destroy();
		
		
		mysqli_close($dbc);
	}
}
?>
</section>
    </div>
    </body>
</html>