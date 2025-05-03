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
    <link rel="stylesheet" href="css/dropdown.css">
    <script src="js/social.js"></script>
    <script src="js/calendar.js"></script>
    <script src="js/random.js"></script>
<script src="js/dropdownmenu.js"></script>
</head>
<body onmouseover="prikazi_datum(), dohvati_kalendar_nova_verzija()" onload="slike()">
    <div class="con">
        <nav>
        <div class="dropdown">
    <button class="dropbtn">Profil</button>
    <div class="dropdown-content">
        <a href="registration.php">Registation</a>
        <a href="profile.php">Profile of user</a>
        <a href="terminirajprofil.php">Delete profile</a>
<a href="profilna.php" style="font-size: 10px;">Add profile picture</a>
<a href="update_profilne.php" style="font-size: 10px;">Update profile picture</a>
<a href="login.php" target="_blank">Login</a>
<a href="logout.php" target="_blank">Logout</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Privacy, feedbacks</button>
    <div class="dropdown-content">
        <a href="privacy.php" target="_blank" style="font-size: 12px;">Terms of privacy</a>
         
        <a href="feedback.php" target="_blank">Add feedback</a>
        <?php 
        if($_SESSION['role']=="Administrator"){
            echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer' style='font-size: 10px;'>Trenutni feedbackovi</a>";
        };?>
    </div>
  </div>
    <?php
    if($_SESSION['role']=="Administrator"){
        echo "<div class='dropdown'>";
        echo "<button class='dropbtn'>Admin options</button>";
        echo "<div class='dropdown-content'>";
        echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>Set user roles</a>";
        echo "<a href='update_roles_for_all.php' target='_blank' rel='noopener noreferrer'>Update all roles</a>";    
        echo "</div>";
     echo "</div>";

}
?>

<div class="dropdown">
    <button class="dropbtn">Forumi,chatovi, početna</button>
    <div class="dropdown-content">
    <a href="forum.php" target="_blank" rel="noopener noreferrer">Forum</a>
    <a href="index.html" target="_blank" rel="noopener noreferrer">Back to home page</a>
    </div>
  </div>

        </nav>

    </div>
    <section id="cal" class="cl">
        <h2>Calendar for March 2025</h2>
        <p id="calendar"></p>
    </section>
    <section id="randslike">
<h2>Random slike</h2>
<p id="s"></p>
    </section>
    <div class="pravila">
<?php 
$sql="SELECT imageId,imageType,imageData FROM profilna WHERE email='$username'";
$res=mysqli_query($dbc,$sql);
while($row=mysqli_fetch_array($res)){
    echo "<label for='profilna'>User image:</label> <br>";
    echo '<img src="data:'.$row['imageType'].';base64,'.base64_encode($row['imageData']).'"width="100%" height="100%" />';
    $id=$row['imageId'];
    //privremene varijable i podaci od slika profila iz baze podataka
    //privremeni podaci koji bi se trebali spremati u bazu podataka
    //te podatke bi trebalo prosljediti funkciji koja će spremati history data od usera 
    //funkcija će se aktivirati nakon što se pošalju podaci save profile history php skripti.
    $email=$username;
    $uid=$ro['imageId'];
    $uimgtp=$row['imageType'];
    $uimgdt=$row['imageData'];
   //trebalo bi razmisliti da se prvo prilikom dodavanja slike profila spreme i files dodaci
   //ovo bi trebalo ići tamo gdje je imgdata i properties kod uploada file-a
    //$serial=getSerialNumberFromDatabase();
    //saveProfileHistory($serial,$uimgtp,$uimgdt,$email);
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
    <input type="file" name="userImage2" class="inputFile" value="<?php echo  $row['imageData'] ?>">
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
        //echo "Do you want to save your previous profile picture?";
        //echo "<form action='save_profile_picture_history.php' method='post'>
        //<input name='odgovor' type='checkbox' value='yes'>Yes <br>
        //<input name='odgovor' type='checkbox' value='no'>No <br>
        //<input type='submit' value='Odgovor'>
        //</form>";
           //echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
           //ovdje treba koristizti fukciju za spremanje history-a
           //u history će se spremiti slika koja se sprema u bazu trenutno.
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