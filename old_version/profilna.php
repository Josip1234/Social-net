<?php 
include "dbconn.php";
include "functions.php";
session_start();
if(!isset($_SESSION['username'])){
	header('Location: registration.php');
}else{
	if($_SESSION['role']!="Administrator"){
		//header('Location: profile.php');
		$_SESSION['login']=time();
	}else{
		$_SESSION['login']=time();
	}
	
}
$dali_postoji_profilna_već_u_bazi=provjeri_postoji_li_već_slika_profila_u_bazi($_SESSION['username']);
if($dali_postoji_profilna_već_u_bazi==1){
    echo "<script type='text/javascript'> document.location = 'update_profilne.php'; </script>";
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
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
<a href="login.php" target="_self">Login</a>
<a href="logout.php" target="_self">Logout</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Privacy, feedbacks</button>
    <div class="dropdown-content">
        <a href="privacy.php" target="_self" style="font-size: 12px;">Terms of privacy</a>
         
        <a href="feedback.php" target="_self">Add feedback</a>
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
    <a href="forum.php" target="_self" rel="noopener noreferrer">Forum</a>
    <a href="index.html" target="_self" rel="noopener noreferrer">Back to home page</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Photos</button>
    <div class="dropdown-content">
    <a href="print_profile_history.php" target="_self" rel="noopener noreferrer">Print profile history images</a>
    <a href="galerija.html" target="_self" rel="noopener noreferrer">Photo gallery</a>
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
    <section id="valut">
       <iframe src="valutaV3.html" seamless></iframe>
    </section>
<div class="pravila">
<section><h2>Set your profile picture here</h2>
<?php
//prilikom uploada ovdje prva slika od profila bi se trebala spremiti u history
if(count($_FILES) > 0) {
if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
$username=$_SESSION['username'];
$imgData =addslashes(file_get_contents($_FILES['userImage']['tmp_name']));
$imageProperties = getimageSize($_FILES['userImage']['tmp_name']);
//save profile history
saveProfileHistory(getSerialNumberFromDatabase(),$imageProperties,$imgData,$username);
$sql = "INSERT INTO profilna(imageType ,imageData, email)
VALUES('{$imageProperties['mime']}', '{$imgData}','$username')";
$query=mysqli_query($dbc,$sql);
if($query){
	echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
}else{
	echo "Failed to insert profile picture into database.";
}
mysqli_close($dbc);



}}
?>
<form name="frmImage" enctype="multipart/form-data" action="profilna.php" method="post" class="frmImageUpload">
<label>Upload Image File:</label><br/>
<input name="userImage" type="file" class="inputFile" />
<input type="submit" value="Submit" class="btnSubmit" />
</form>
</div>

<footer>
	<div id="datum"></div>
</footer>

</body>
</html>