<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<script src="socialnet.js"></script>
<script src="calendar.js"></script>
</head>

<?php include "functions.php"; echo printBodyOnMouseOver(); ?>

<div class="con">
<nav>

<?php require_once "navigacija.php"; 
require_once "dbconn.php";
?>

</nav>
</div>
<?php echo printCalendar(); ?>
<div class="pravila">
<section><h2>Profile deletion</h2>

<form action="terminirajprofil.php" method="post">
<label>Are you sure you want to terminate/delete your account?</label><br/>
<input type="checkbox" name="odgovor" value="yes">Yes 
<input type="checkbox" name="odgovor" value="no">No
<input type="submit" value="Confirm"> 
</form>
<?php
if($_SERVER["REQUEST_METHOD"]==="POST"){
$odgovor=$_POST['odgovor'];
$username=$_SESSION["username"];
if($odgovor=='yes'){
	$upit="DELETE FROM registration WHERE email ='$username'";
	$o=mysqli_query($dbc,$upit);
	if($o){
        logout();
		echo "Profile deleted"."<a href='index.html'>Back to homepage</a>";
		mysqli_close($dbc);
	}else{
		echo "Delete failed";
		mysqli_close($dbc);
	}
}else if($odgovor=='no'){
	header("Location:profile.php");
}
}
?>
</section>
</div>


<?php 
echo printFooter();
?>
</body>
</html>