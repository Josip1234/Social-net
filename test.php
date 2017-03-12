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
$obavljeno=1;
$user_id=1;
$sql="INSERT INTO obavljeno (obavljeno,user_id) VALUES ($obavljeno,$user_id)";
mysqli_query($dbc,$sql);
echo "Sucessfull updated table";
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