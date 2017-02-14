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
<section>
<?php
$sql="SELECT `registration`.`id`, `registration`.`email`, `uloge`.`id`, `uloge`.`user_id`, `uloge`.`uloga`
FROM `registration`
LEFT JOIN `uloge` ON `registration`.`id` = `uloge`.`user_id`";

?>
</section>
</div>



</body>
</html>
