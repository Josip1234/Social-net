<?php 
include "dbconn.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
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
    <a href="addtogallery.php" target="_self">Add to gallery</a>
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
<section>
<h2>Your feedback</h2>
<form action="feedback.php" method="post">
<label>Your first name:</label><br/>
<input type="text" name="fname" required autocomplete="off"/><br/>
<label>Your last name:</label><br/>
<input type="text" name="lname" required autocomplete="off"/><br/>
<label>Suggestions of improvment:</label><br/>
<textarea name="suggestions" required></textarea>
<br/>
<input type="submit" value="Send suggestion"/>
</form>
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
$fname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
//riješen problem dodavanja praznih redaka za fname, lname i suggestions
if($fname!=''){
	//strip_tags uklanjaju php i html oznake, trim uklanja nepotreban razmak ili druge znakove sa oba kraja stringa 
	//mysqli_real_escape sa ostalim objašnjenim funkcijama sprječavaju sql injekciju
$lname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
if($lname!=''){
$suggestions=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['suggestions'])));
if($suggestions!=''){
$query="INSERT INTO kvaliteta (firstname,lastname,suggestion) VALUES ('$fname','$lname','$suggestions')";
mysqli_query($dbc,$query);
mysqli_close($dbc);
include("functions.php");
if($query){
	echo "<script type='text/javascript'> document.location = 'index.html'; </script>";
}else{
	die("Error! Information not inserted!");
}
}
}
}else{
	die("Can 't add empty informations");
}
}
?>
</section>

</div>

<footer>
    <p id="datum"></p>
    </footer>

</body>
</html>