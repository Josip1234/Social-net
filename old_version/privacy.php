<?php 
include "dbconn.php";
session_start();


?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet-privacy</title>
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
  <div class="dropdown">
    <button class="dropbtn">Photos</button>
    <div class="dropdown-content">
    <a href="print_profile_history.php" target="_blank" rel="noopener noreferrer">Print profile history images</a>
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
<section>
<h2>Basic rules of use this site</h2>
<ol>
<li>When you are register and login into the site, you are agreeing to give us your sensitive data like username, email, password.</li>
<li>We are not responsible if you give some other person your password, and if that results that that person is misusing our site , you will still be banned for our site, your serial will be blacklisted and you wont be able to register again.</li>
<li>Serial presents email. If you make new registration from new device or email, and you still misusing our site, you will be prosecuted by law.</li>
<li>Any criminal activity, drug dealing, or some other things will get you punished. </li>
<li>Dont insult others and behave yourself good on this site. If you break the rule, you will get some negative points. 
If you collect more than 50 negative points, you will be banned for 1 day. </li>
<li>For every other 50 points, you will be banned for 2 days, other 4 days, etc.</li>
<li>Your data will have a daily backup. If you want some backuped files to have on your computer, just give us some feedback. Use <a href="feedback.php" target="_blank">feedback</a> form, to get us request, you will get your data through email.</li>
<li>You can in your feedback also, sent us some suggestions to improve our page like design, to add some additional content, etc..</li>
</ol>
</section>
</div>


<footer>
    <p id="datum"></p>
</footer>
</body>
</html>