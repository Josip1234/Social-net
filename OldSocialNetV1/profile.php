<?php
include "functions.php";
loggedUsersOnly();

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

<?php include "navigacija.php"; ?>

</nav>
</div>
<div class="pravila">
<section><h2>Your profile</h2>
<?php
$username=$_SESSION["username"];
$sql="SELECT imageId,imageType,imageData from profilna where email='$username'";
$res=mysqli_query($dbc,$sql);
while($ro=mysqli_fetch_array($res)){
    $img='<img src="data:'.$ro['imageType'].';base64,'.base64_encode( $ro['imageData'] ).'"width="100" height="100" ';
    $alt="alt=".$ro["imageId"]."/>";
    $pit=$img.$alt;
    echo $pit;
    };
?>



</section>
</div>



</body>
</html>