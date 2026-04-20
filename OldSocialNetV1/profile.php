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

<?php include "navigacija.php"; 
loggedUsersOnly();
?>

</nav>
</div>
<div class="pravila">
<section><h2>Your profile</h2>
<p>User image</p>
<?php
$username=$_SESSION["username"];
$sql="select r.fname,r.lname,r.sex,r.dateOfBirth,r.cityOfBirth,r.countryOfBirth, r.email, pr.imageId,pr.imageType,pr.imageData from registration r inner join profilna pr on r.email=pr.email where pr.email='".$_SESSION['username']."';";
$res=mysqli_query($dbc,$sql);
while($ro=mysqli_fetch_array($res)){
    $img='<img src="data:'.$ro['imageType'].';base64,'.base64_encode( $ro['imageData'] ).'"width="50%" height="50%" ';
    $alt="alt=".$ro["imageId"]."/>";
    $pit=$img.$alt;
    echo $pit;
?>
<?php 
$firstName=$ro["fname"];
$lastName=$ro["lname"];
$checked=($ro['sex']==='m')?'m':'z';
$dateOfBirth=$ro["dateOfBirth"];
$cityOfBirth=$ro["cityOfBirth"];
$stateOfBirth=$ro["countryOfBirth"];
$email=$ro["email"];
};
mysqli_close($dbc);
?>

<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="fname">First name:</label> <br>
    <input type="text" name="fname" id="fname" value="<?= $firstName; ?>"> <br>
    <label for="lname">Last name:</label> <br>
    <input type="text" name="lname" id="lname" value="<?= $lastName; ?>"> <br>
    <label for="sex">Sex:</label> <br>
    <input type="radio" name="sex" id="sex" value="m" <?= ($checked==='m')?'checked':''; ?> required>M 
    <input type="radio" name="sex" id="sex" value="z" <?= ($checked==='z')?'checked':''; ?>>Z  <br>
    <label for="dateOfBirth">Date of birth:</label> <br>
    <input type="date" name="dateOfBirth" id="dateOfBirth" value="<?= $dateOfBirth; ?>"> <br>
    <label for="cityOfBirth">City of birth:</label> <br>
    <input type="text" name="cityOfBirth" id="cityOfBirth" value="<?= $cityOfBirth; ?>"> <br>
    <label for="countryOfBirth">State of birth:</label> <br>
    <input type="text" name="countryOfBirth" id="countryOfBirth" value="<?= $stateOfBirth; ?>"> <br>
    <label for="email">Email:</label> <br>
    <input type="email" name="email" id="email" value="<?= $email; ?>"> <br>
    <input type="submit" value="Update">

</form>


</section>
</div>



</body>
</html>