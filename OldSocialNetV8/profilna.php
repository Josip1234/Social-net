<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location:login.php');
}else{
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
            <a href="#" target="_self" >Registration</a>
            <a href="#" target="_self" >Login</a>
            <a href="profile.php" target="_self">Profile of user</a>
            <a href="logout.php" target="_self">Logout</a>
            <a href="dodjeli_uloge.php" target="_self">Set user roles</a>
                <a href="feedback.php" target="_self">Add feedback</a>
        </nav>
    </div>
    <div class="pravila">
        <section>
            <h2>
                Set your profile picture here
            </h2>
            <?php 
include("dbconn.php");
if(count($_FILES)>0){
    if(is_uploaded_file($_FILES['userImage']['tmp_name'])){
        
        $imgData=addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
        $imageProperties= getimagesize($_FILES['userImage']['tmp_name']);
        $sql="INSERT INTO profilna(imageType,imageData) VALUES ('{$imageProperties['mime']}','{$imgData}')";
        mysqli_query($dbc, $sql);
        mysqli_close($dbc);
    }
}
            ?>
            <form name="frmImage" enctype="multipart/form-data" action="profilna.php" method="post" class="frmImageUpload">
           <label>
               Upload image file:
           </label><br>
           <input type="file" name="userImage" class="inputFile"> 
           <input type="submit" value="Submit" class="btnSubmit">
        </form>
        </section>
    </div>
</body>
</html>