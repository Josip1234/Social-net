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
        <section>
            <h2>Your profile</h2>
            <?php 
            include("dbconn.php");
            $sql="SELECT imageId, imageType, imageData FROM profilna WHERE email='$username'";
            $res=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($res)){
                   echo "<label>User image:</label><br>";
                   echo '<img src="data:'.$row['imageType'].';base64,'.base64_encode($row['imageData']).'" width="100" height="100"/>';
            }
            $sql2="SELECT fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email FROM registration WHERE id='$id'";
            $t=mysqli_query($dbc,$sql2);
            while($o=mysqli_fetch_array($t)){
                ?>
                <form action="profile.php" method="post">
                    <label>First name:</label> <br>
                    <input type="text" name="firstname" value="<?php echo $o['fname']; ?>"> <br>
                    <label>Last name:</label> <br>
                    <input type="text" name="lastname" value="<?php echo $o['lname']; ?>"> <br>
                    <label>Sex:</label> <br>
                    <input type="text" name="sex" value="<?php echo $o['sex']; ?>"> <br>
                    <label>Date of birth:</label> <br>
                    <input type="date" name="datum" value="<?php echo $o['dateofbirth']; ?>"> <br>
                    <label> City of birth:</label> <br>
                    <input type="text" name="cityofbirth" value="<?php echo $o['cityofbirth']; ?>"> <br>
                    <label>Country of birth:</label> <br>
                    <input type="text" name="countryofbirth" value="<?php echo $o['countryofbirth']; ?>"> <br>
                    <label>Pass:</label> <br>
                    <input type="text" name="pass" value="<?php echo $o['pass']; ?>"> <br>
                    <label>Email:</label> <br>
                    <input type="email" name="email" value="<?php echo $o['email']; ?>"> <br>
                  <?php 
                   }
                   mysqli_close($dbc);
                  ?>
                  <input type="submit" value="Update">
                </form>
           
           <?php
                  
            ?>
        </section>

    </div>
</body>
</html>