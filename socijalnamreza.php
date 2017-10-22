<?php
include "dbconn.php";
session_start();

if(!isset($_SESSION['username'])){
	header('Location: profile.php');
}else{    
         if($_SESSION['role']!="Administrator"){
			 header('Location:profile.php');
		 }else{
			$_SESSION['login']=time();
			
		 }
		}

?>



<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="/mreza/style.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>


<?php
	if($_SERVER['REQUEST_METHOD']=="POST"){
		include "dbconn.php";
		$user=$_SESSION['username'];
		$id=$_GET[id];
		
		echo $id;
		echo "<br>";
		echo $user;
		echo "<br>";
		$obavljeno=$_POST['check'];
		echo $_POST['check'];
		$query="INSERT INTO `obavljeno` (`id_feedbacka`, `obavljeno`, `email`) VALUES ('$id', '$obavljeno', '$user')";
		$a=mysqli_query($dbc,$query);
		if($a){
			echo "Succesfull inserted feedback";
		}else{
			echo "error";
		}
		mysqli_close($dbc);
		
	}else{
	$q=intval($_GET['q']);

	$sql="SELECT id,firstname,lastname,suggestion FROM kvaliteta WHERE id = '".$q."'";
	$result=mysqli_query($dbc,$sql);
	
	echo 
		"<h2>Selected values:</h2><br><table>
	<tr>
	<th>id</th>
	<th>First name</th>
	<th>Last name</th>
	<th>Suggestion</th>
	<th>Is it done?</th>
	
	</tr>";
	while($row=mysqli_fetch_array($result)){
		echo "<tr>";
		echo "<td>".$row[id]."</td>";
		echo "<td>".$row['firstname']."</td>";
		echo "<td>".$row['lastname']."</td>";
		echo "<td>".$row['suggestion']."</td>";
		echo "<td><form action='socijalnamreza.php?id=$row[id]' method='post'><input type='checkbox' name='check' value='1'>Done <br> <input type='submit' value='send'></form></td>";
		
		echo "</tr>";
	}
	echo "</table>";
		
   $ch=$_POST['check'];
	if($ch==1){
		$checked=1;
	}else{
		$checked=0;
	}
	$check=$_POST[$cheked];	
		
		
		$user=$_POST[$_SESSION['username']];
		$id=$_POST[$row[id]];
		
		
	
	
	mysqli_close($dbc);
	
	/*
	Explanation: When the query is sent from the JavaScript to the PHP file, the following happens:

PHP opens a connection to a MySQL server
The correct person is found
An HTML table is created, filled with data, and sent back to the "txtHint" placeholder
	
	*/
	}
	?>
</body>
</html>