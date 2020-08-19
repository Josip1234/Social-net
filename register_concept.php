<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register here</title>
</head>
<body>
<?php  
$firstname="";
$lastname="";
$email="";
$dateofbirth="";
$sex="";
$placeofbirth="";
$profile="";
$password="";
$confirm="";

?>
    <form action="register_concept.php" method="post">
    <label for="firstname">Enter your first name:</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Enter your last name:</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Enter your email:</label>
    <input type="email" name="email" id="email">
    <label for="dateofbirth">Enter yur date of birth:</label>
    <input type="date" name="dateofbirth" id="dateofbirth">
    <label for="sex">Select your sex:</label>
    <select name="sex" id="sex">
     <option value="m">Male</option>
     <option value="f">Female</option>
    </select>
    <label for="placeofbirth">Enter your place of birth:</label>
    <textarea name="placeofbirth" id="placeofbirth" cols="30" rows="10"></textarea>
    <label for="profile">Add your profile picture:</label>
    <input type="file" name="profile" id="profile">
    <label for="password">Enter your password:</label>
    <input type="password" name="password" id="password">
    <label for="confirm">Re-type your password:</label>
    <input type="password" name="confirm" id="confirm">
    <input type="submit" value="Register">
    </form>

<?php 

$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$email=$_POST['email'];
$dateofbirth=$_POST['dateofbirth'];
$sex=$_POST['sex'];
$placeofbirth=$_POST['placeofbirth'];
$profile=$_POST['profile'];
$password=$_POST['password'];
$confirm=$_POST['confirm'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    echo 
    $firstname."".
$lastname."".
$email."".
$dateofbirth."".
$sex."".
$placeofbirth."".
$profile."".
$password."".
$confirm;
}else{
    echo "No data was sent by the user.";
}

?>

</body>
</html>