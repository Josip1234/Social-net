<?php 
include "dbconn.php";
session_start();
if(!isset($_SESSION['username'])){
	header('Location: registration.php');
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
            <a href="registration.php" target="_blank" rel="noopener noreferrer">Registration</a>
            <a href="login.php" target="_blank" rel="noopener noreferrer">Login</a>
            <?php 
            if($_SESSION['role']=="Administrator"){
echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>User roles</a>";
echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer'>Feedbacks</a>";
}
?>
<a href="feedback.php" target="_blank" rel="noopener noreferrer">Add feedback</a>
<a href="terminirajprofil.php" target="_blank" rel="noopener noreferrer">Delete profile</a>
<a href="privacy.php" target="_blank" rel="noopener noreferrer">Terms of privacy</a>
<a href="profile.php" target="_blank" rel="noopener noreferrer">Profile of user</a>
<a href="logout.php" target="_blank" rel="noopener noreferrer">Logout</a>
        </nav>

    </div>
    <div class="pravila">
<?php 
$sql="SELECT imageId,imageType,imageData FROM profilna WHERE email='$username'";
$res=mysqli_query($dbc,$sql);
while($row=mysqli_fetch_array($res)){
    echo "<label for='profilna'>User image:</label> <br>";
    echo '<img src="data:'.$row['imageType'].';base64,'.base64_encode($row['imageData']).'"width="100%" height="100%" />';
    $id=$row['imageId'];
    $uimgtp=$ro['imageType'];
    $uimgdt=$ro['imageData'];
}

?>
<form action="update_profilne.php" enctype="multipart/form-data" method="post" class="frmImageUpload" name="frmImage1">
    <label for="upload">Upload image file:</label> <br>
    <input type="file" name="userImage2" class="inputFile">
    <input type="submit" value="Submit" class="btnSubmit">
</form>
<?php 
if(count($_FILES)>0){
    if(is_uploaded_file($_FILES['userImage2']['tmp_name'])){
        $imgData=addslashes(file_get_contents($_FILES['userImage2']['tmp_name']));
        $imageProperties=getimagesize($_FILES['userImage2']['tmp_name']);
        $sql="UPDATE profilna SET imageType='{$imageProperties['mime']}', imageData='{$imgData}' WHERE email='$username'";
        $succ=mysqli_query($dbc,$sql);
        if($succ){
            mysqli_close($dbc);
            //fix za redirection ako ne radi ipak 
            //ob_start();
           // header( "refresh:5;url=http://localhost/Social-net/old_version/profile.php" );
            //echo 'You\'ll be redirected in about 5 secs. If not, click <a href="profile.php">here</a>.';
           //ob_end_flush();
           //pravi fix koji radi
           echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
        }else{
            die('Cannot update profile picture.');
            mysqli_close($dbc);
        }
        
    }
}


?>
    </div>
</body>
</html>