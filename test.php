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

<?php
if(isset($_POST['formWheelchair']) && 
$_POST['formWheelchair'] == 'Yes') 
{
echo "Need wheelchair access.";
}
else
{
echo "Do not Need wheelchair access.";
}    
?>
</body>
</html>