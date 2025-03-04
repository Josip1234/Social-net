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
</head>

<body>

<div class="con">
<nav>

<a href="registration.php" target="_blank">Registration</a>
<a href="login.php" target="_blank">Login</a>
<a href="privacy.php" target="_blank">Terms of privacy</a>
<?php 

if($_SESSION['role']=="Administrator"){
echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer'>Trenutni feedbackovi</a>";
}
?>
<a href="index.html" target="_blank">Back to main page</a>
<a href="profile.php" target="_blank" rel="noopener noreferrer">Profile of user</a>
<a href="logout.php" target="_blank" rel="noopener noreferrer">Logout</a>
<a href="terminirajprofil.php" target="_blank" rel="noopener noreferrer">Delete profile</a>
<?php 

if($_SESSION['role']=="Administrator"){
echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>User roles</a>";
}
?>
<a href="feedback.php" target="_blank" rel="noopener noreferrer">Add feedback</a>
</nav>
</div>
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



</body>
</html>