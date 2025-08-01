<?php 
include "dbconn.php";
session_start();
if(!isset($_SESSION['username'])){
	header('Location: registration.php');
}else{
	if($_SESSION['role']!="Administrator"){
		header('Location: profile.php');
	}else{
		$_SESSION['login']=time();
	}
	
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
<section id="sec"><h2>Feedbackovi</h2>
<table>
<?php
//SELECT ALL VALUES WHICH ARE NOT DONE YET
$query="SELECT kvaliteta.id,kvaliteta.firstname,kvaliteta.lastname,kvaliteta.suggestion FROM kvaliteta,obavljeno WHERE kvaliteta.id <> obavljeno.id_feedbacka";
$q=mysqli_query($dbc,$query);
while($row=mysqli_fetch_array($q)){
	echo"<tr>";
	echo"<td>".$row['id']." ".$row['firstname']." ".$row['lastname']." ".$row['suggestion']." <form action='trenutnifeedback.php' method='post'><input type='checkbox' name='obavljeno' value='Yes'/><label>Obavljeno?</label>
  <input type='hidden' name='id_feedbacka' value='".$row['id']."'>
  <input type='submit' name='formSubmit' value='Posalji'></form></td>";
	echo "</tr>";
};
?>
</table>
<?php 
if($_SERVER["REQUEST_METHOD"]=="POST"){
$obavljeno=$_POST['obavljeno'];

  $done=1;
  echo "Obavljeno=".$done;
  $id_feedbacka=$_POST['id_feedbacka'];
echo "Id feedbacka:".$id_feedbacka;
$email=$_SESSION['username'];
echo "User who check feedback:".$email;
 $sql="INSERT INTO `obavljeno` ( `obavljeno`, `id_feedbacka`, `email`) VALUES ( '$done', '$id_feedbacka', '$email')";
mysqli_query($dbc,$sql);
mysqli_close($dbc);

}

?>
</section>
</div>


<footer>
	<p id="datum"></p>
</footer>
</body>
</html>