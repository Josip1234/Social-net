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

<?php require_once "navigacija.php"; 
require_once "dbconn.php";

$checked="";
loggedUsersOnly();
?>

</nav>
</div>
<div class="pravila">
<section><h2>Your profile</h2>
<?php 
if(isset($_SESSION["success"])){
    if(!empty($_SESSION["success"])){
        echo "<p>{$_SESSION['success']}</p>";
        unset($_SESSION["success"]);
    }
}


?>
<p>User image</p>
<?php
$username=$_SESSION["username"];
$sql="select r.fname,r.lname,r.sex,r.dateOfBirth,r.cityOfBirth,r.countryOfBirth, r.email, pr.imageId,pr.imageType,pr.imageData,u.uloga from registration r inner join profilna pr on r.email=pr.email 
inner join uloge u on r.id=u.user_id
where pr.email='".$_SESSION['username']."';";
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
$sex1=$ro['sex'];
$checked=($ro['sex']==='m')?'m':'z';
$dateOfBirth=$ro["dateOfBirth"];
$cityOfBirth=$ro["cityOfBirth"];
$stateOfBirth=$ro["countryOfBirth"];
$email=$ro["email"];
$ul=$ro["uloga"];

//previously saved user data will be used to compare values
$_SESSION["firstName1"]=$firstName;
$_SESSION["lastName1"]=$lastName;
$_SESSION["sex1"]=$sex1;
$_SESSION["dateOfBirth1"]=$dateOfBirth;
$_SESSION["cityOfBirth1"]=$cityOfBirth;
$_SESSION["countryOfBirth1"]=$stateOfBirth;
$_SESSION["email1"]=$email;
$_SESSION["uloga1"]=$ul;

};

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
    <label for="uloga">Role:</label> <br>
    <input type="text" name="uloga" id="uloga" value="<?= $ul; ?>" readonly>
    <br>
    <input type="submit" value="Update">

</form>

<?php 
if($_SERVER["REQUEST_METHOD"]==="POST"){
    //data values sent via form
    $id=$_SESSION["id"];
    $fname=$_POST["fname"];
    $lname=$_POST["lname"];
    $sex=$_POST["sex"];
    $dbirth=$_POST["dateOfBirth"];
    $cbirth=$_POST["cityOfBirth"];
    $countryOfBirth=$_POST["countryOfBirth"];
    $em=$_POST["email"];
    $role=$_POST["uloga"];

    $updateFailed="Update failed";
    $updateSuccessfull="Update successfull";

    $updateFields=[];

    $tableName="registration";
    $columnValue=[];

    if($fname!=$_SESSION["firstName1"]){
        echo "First name has been changed.";
        //validation will be made after check if some value has been changed
        $updateFields["fname"]=$fname;
    }
    if($lname!=$_SESSION["lastName1"]){
        echo "Last name has been changed.";
        $updateFields["lname"]=$lname;
    }

    if($sex!=$_SESSION["sex1"]){
        echo "Sex has been changed.";
        $updateFields['sex']=$sex;
    }

    if($dbirth!=$_SESSION["dateOfBirth1"]){
        echo "Date of birth has been changed.";
        $updateFields['dateOfBirth']=$dbirth;
    }
    if($cbirth!=$_SESSION["cityOfBirth1"]){
        echo "City of birth has been changed.";
        $updateFields['cityOfBirth']=$cbirth;
    }
    if($countryOfBirth!=$_SESSION["countryOfBirth1"]){
        echo "Country of birth has been changed.";
        $updateFields['countryOfBirth']=$countryOfBirth;
    }
    if($em!=$_SESSION["email1"]){
        echo "Email has been changed.";
        $updateFields["email"]=$em;
    }
    if($role!=$_SESSION["uloga1"]){
        echo "Role has been changed.";
        $updateFields["uloga"]=$role;
    }
    $columnValue["id"]=$id;
    $query=createUpdateQuery($updateFields,$tableName,$columnValue);
    $stmt=mysqli_query($dbc,$query);
    if($stmt){
        $_SESSION["success"]=$updateSuccessfull;
        echo '<meta http-equiv="refresh" content="0">';
    }else{
        echo $updateFailed;
    }

   unsetProfileSessions();
    

}


mysqli_close($dbc);
?>

</section>
</div>



</body>
</html>