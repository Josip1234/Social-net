<?php 
session_start();
session_unset();
session_destroy();
header('Location:login.php');


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
    <a href="#" target="_self" rel="noopener noreferrer">Registration</a>
    <a href="#" target="_self" rel="noopener noreferrer">Login</a>
</nav>
    </div>
    <section id="cal" class="cl">
        <h2>Calendar for March 2025</h2>
        <p id="calendar"></p>
    </section>
    <div class="pravila">
<section>
    <h2>Privacy rules</h2>
    <p>Your data will be protected. Any unauthorised use of your data from our employees will be prosecuted by the law of our country. Do not use passwords if you are already use in your other emails, or site logins. Always use password not less than 8 bites and use at least 1 number and 1 small and 1 big letter. To accept our rules of privacy, visit <a id="privatnost" href="privacy.php" target="_self">privacy</a> and check if you are agree. Other information will be here also.</p>
</section>
    </div>
    <footer>
	<p id="datum"></p>
</footer>
</body>
</html>