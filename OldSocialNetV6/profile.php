<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
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
                
                   echo '<img src="data:'.$row['imageType'].';base64,'.base64_encode($row['imageData']).'" width="100" height="100"/>';
            }
            mysqli_close($dbc);
                  
            ?>
        </section>

    </div>
</body>
</html>