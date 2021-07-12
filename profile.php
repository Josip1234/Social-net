<?php
session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
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
</head>
<body>
    <div class="con">
        <section>
            <h2>Your profile</h2>
            <img src="<?php ?>" alt="profile_picture"><br/>
        </section>

    </div>
</body>
</html>