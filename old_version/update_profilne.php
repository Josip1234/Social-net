<?php 
include "dbconn.php";
include "functions.php";
//generiraj serijski prilikom svakog posjeta ovoj stranici
$serijski=generiraj_random_serijski(rand(0,30),rand(0,255));
spremi_serijski_u_bazu($serijski);
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
    <script src="js/social.js"></script>
    <script src="js/calendar.js"></script>
</head>
<body onmouseover="prikazi_datum(), dohvati_kalendar_nova_verzija()">
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
    <section id="cal" class="cl">
        <h2>Calendar for March 2025</h2>
        <p id="calendar"></p>
    </section>
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
    //spremi u privremenu bazu podatke o slikama sa nekim random unique id-om, i tablica kao u profilnoj
   //ako korisnik potvrdi da ne želi spremiti onda izbriši iz baze
   //dodana tablica serial number koja će sadržavati random serijske brojeve iz koje će se vaditi podaci za serial image 
   //serial image u tablici table history je vezan za serial_numbers
   //za svaki klik na stranici prvo generiraj random number
   //zatim provjeri dali postoji u bazi 
   //ako ne postoji dodaj u bazu 
   //napiši u funkciju tako
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
        echo "Update successfull.";
        echo "Do you want to save your previous profile picture?";
        echo "<form action='save_profile_picture_history.php' method='post'>
        <input name='odgovor' type='checkbox' value='yes'>Yes <br>
        <input name='odgovor' type='checkbox' value='no'>No <br>
        <input type='submit' value='Odgovor'>
        </form>";
           //echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
        }else{
            die('Cannot update profile picture.');
            mysqli_close($dbc);
        }
        
    }
}


?>
    </div>
    <footer>
	<p id="datum"></p>
</footer>
</body>
</html>