<?php 
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}else{
    $id=$_SESSION['id'];
    $username=$_SESSION['username'];
    $_SESSION['login']=time();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
</head>
<body>
    <div class="con">
<nav>
    <a href="#" target="_blank" rel="noopener noreferrer">Registration</a>
    <a href="#" target="_blank" rel="noopener noreferrer">Login</a>
    <a href="logout.php" target="_blank" rel="noopener noreferrer">Logout</a>
</nav>
    </div>
    <div class="pravila">
<section>
    <h2>Your profile</h2>
   <!-- <img src="<?php ?>" alt="profile_picture"><br/>-->
    <?php //samo ispisujemo podatke ovdje trebamo stvoriti gumb za update, podaci se ispisuju prema id-u korisnika koji je trenutno ulogiran  ?>
    <?php  
    include("dbconn.php");
    $sql="SELECT imageId, imageType, imageData FROM profilna WHERE email = '$username'";
    $res=mysqli_query($dbc,$sql);
    while($ro=mysqli_fetch_array($res)){
        echo "<label>User image:</label><br/>";
        echo '<img src="data:'.$ro['imageType'].';base64,'.base64_encode($ro['imageData']).'"width="100" height="100" />';
    }
    $sql2="SELECT fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email FROM registration WHERE id='$id'";
    $t=mysqli_query($dbc,$sql2);
    while($o=mysqli_fetch_array($t)){
        $fname=$o['fname'];
        $lname=$o['lname'];
        $sex=$o['sex'];
        $dtb=$o['dateofbirth'];
        $ctb=$o['cityofbirth'];
        $coub=$o['countryofbirth'];
        $sif=$o['pass'];
        $e=$o['email'];
    }?>
    <form action="profile.php" method="post">
        <label for="fname">First name:</label><br>
        <input type="text" name="fname" id="fname" value="<?php echo $fname;  ?>"> <br>
        <label for="lname">Last name:</label> <br>
        <input type="text" name="lname" id="lname" value="<?php echo $lname;  ?>"> <br>
        <label for="sex">Sex:</label><br>
        <input type="text" name="sex" id="sex" value="<?php echo $sex; ?>"> <br>
        <label for="dateofbirth">Date of birth:</label> <br>
        <input type="date" name="dateofbirth" id="dateofbirth" value="<?php echo $dtb; ?>"> <br>
        <label for="cityofbirth">City of birth:</label> <br>
        <input type="text" name="cityofbirth" id="cityofbirth" value="<?php echo $ctb; ?>"> <br>
        <label for="countryofbirth">Country of birth:</label><br>
        <input type="text" name="countryofbirth" id="countryofbirth" value="<?php echo $coub; ?>"> <br>
        <label for="pass">Pass:</label> <br>
        <input type="text" name="pass" id="pass" value="<?php echo $sif; ?>"> <br>
        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" value="<?php echo $e; ?>"> <br>
        <input type="submit" value="Update">
    </form>
    <?php
    mysqli_close($dbc);
    ?>
    
</section>
    </div>
</body>
</html>