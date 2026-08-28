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
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>
<div class="pravila">
<?php
include("dbconn.php");
if(isset($_POST['formWheelchair']) && 
$_POST['formWheelchair'] == 'Yes') 
{

$sql="INSERT INTO obavljeno (id_feedbacka,obavljeno,email) VALUES ()";
mysqli_query($dbc,$sql);
echo "Sucessfull updated table";
echo $id;
mysqli_close($dbc);
}
else
{
echo "Do not Need wheelchair access.";
}    
?>
</div>

</body>
</html>