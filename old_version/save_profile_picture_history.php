<?php 
$odgovor=$_POST['odgovor'];
if($odgovor=="yes"){
    echo "Save previous picture.";
}else{
    echo "<script type='text/javascript'> document.location = 'profile.php'; </script>";
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
        <?php 
         

?>
<nav>
    <a href="registration.php" target="_blank" rel="noopener noreferrer">Registration</a>
    <a href="login.php" target="_blank" rel="noopener noreferrer">Login</a>
</nav>
    </div>
    <section id="cal" class="cl">
        <h2>Calendar for March 2025</h2>
        <p id="calendar"></p>
    </section>
    <div class="pravila">
<section>
    <h2>You can save your profile history here.</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut minima, sunt eaque dolor ad nemo aut accusantium repudiandae adipisci fugit quaerat voluptate quisquam repellat distinctio, dolorem corporis ducimus veritatis laboriosam?</p>
</section>
    </div>
    <footer>
	<p id="datum"></p>
</footer>
</body>
</html>