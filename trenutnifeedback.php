<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
	$_SESSION['login']=time();
}

?>
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
<a href="privacy.php" target="_blank">Terms of privacy</a>
<a href="trenutnifeedback.php" target="_blank">Feedbacks-only for admins</a>
<a href="profile.php" target="_blank">Profile of user</a>
</nav>
</div>
<div class="pravila">
<section><h2>Feedbackovi</h2>
<table>
<?php
include('dbconn.php');
$query="SELECT * FROM kvaliteta";
$q=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($q)){
	
	echo"<tr>";
	
	echo"<td>".$row[id]."&ensp;".$row['firstname']."&ensp;".$row['lastname']."&ensp;".$row['suggestion']."<br/>
	<form action='test.php' method='post'>
Obavljeno?
<input type='checkbox' name='formWheelchair' value='Yes' />
<input type='submit' name='formSubmit' value='Submit' />


</form>
"."</td>";

    
 
	
	
	


mysqli_close($dbc);


}
?>
</table>
</section>
</div>




</body>
</html>
