<?php
session_start();
session_unset();
session_destroy();
header('Location:login.php');

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
</head>

<body>

<div class="con">
<nav>

<a href="#" target="_blank">Registation</a>
<a href="#" target="_blank">Login</a>

</nav>
</div>
<div class="pravila">
<section><h2>Privacy rules</h2>
<p>Your data will be protected. Any unauthorised use of your data from our employees will be prosecuted by the law of our country. Do not use passwords if you are already use in your other emails, or site logins. Always use password not less than 8 bites and use at least 1 number and 1 small and 1 big letter. To accept our rules of privacy, visit <a id="privatnost" href="privacy.php" target="_blank">privacy </a> and check if you are agree. Other information will be here also.</p>
</section>
</div>



</body>
</html>