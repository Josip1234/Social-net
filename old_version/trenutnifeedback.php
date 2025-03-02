<?php 
include "dbconn.php";
session_start();
if(!isset($_SESSION['username'])){
	header('Location: registration.php');
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
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>

<div class="con">
<nav>

<a href="index.html" target="_blank">Back to main page</a>
<a href="privacy.php" target="_blank">Terms of privacy</a>
<?php 
           if($_SESSION['role']=="Administrator"){
			echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer'>Feedbacks - only for admins</a>";
			}

?>
<a href="profile.php" target="_blank" rel="noopener noreferrer">Profile of user</a>
<a href="index.html" target="_blank" rel="noopener noreferrer">Back to main page</a>
<a href="privacy.php" target="_blank" rel="noopener noreferrer">Terms of privacy</a>
<?php 
            if($_SESSION['role']=="Administrator"){
echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>User roles</a>";
}
?>
<a href="profile.php" target="_blank" rel="noopener noreferrer">Profile of user</a>
<a href="logout.php" target="_blank" rel="noopener noreferrer">Logout</a>
<?php 

if($_SESSION['role']=="Administrator"){
echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>User roles</a>";
}
?>
</nav>
</div>
<div class="pravila">
<section><h2>Feedbackovi</h2>
<table>
<?php

$query="SELECT * FROM kvaliteta";
$q=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($q)){
	echo"<tr>";
	/**echo"<td>".$row['id']."&ensp;".$row['firstname']."&ensp;".$row['lastname']."&ensp;".$row['suggestion']."<br/> <input type='checkbox' name='obavljeno' value='Obavljeno?'/><label>Obavljeno?</label></td>";*/
	echo"<td>".$row['id']."&ensp;".$row['firstname']."&ensp;".$row['lastname']."&ensp;".$row['suggestion']."<br/> <form action='feedbackdone.php' method='post'><input type='checkbox' name='obavljeno' value='Yes'/><label>Obavljeno?</label><input type='submit' name='formSubmit' value='Posalji'></form></td>";
	echo "</tr>";
};
$obavljeno=$_POST['obavljeno'];
mysqli_close($dbc);
?>
</table>
</section>
</div>



</body>
</html>