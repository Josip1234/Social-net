<?php
include("dbconn.php");

session_start();
if(!isset($_SESSION['username'])){
	header('Location: login.php');
}else{
	$id=$_SESSION['id'];
	$username=$_SESSION['username'];
	$_SESSION['login']=time();
	
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socialnet</title>
    <link rel="stylesheet" href="css/stil.css" rel="stylesheet" media="all">
</head>
<body>
    <div class="con">
<nav>
    <a href="registration.php" target="_blank" rel="noopener noreferrer">Registration</a>
    <a href="login.php" target="_blank" rel="noopener noreferrer">Login</a>
</nav>
    </div>
    <div class="pravila">
         <section>
            <h2>Are you sure do you want to terminate/delete your account?</h2>
            <form action="terminirajprofil.php" method="post">
            <input type="checkbox" name="odgovor" id="yes" value="yes">Yes 
            <input type="checkbox" name="odgovor" id="no" value="no">No
            <input type="submit" value="Confirm">

            </form>
       <?php
       //prije delete-a,m potrebno je provjeriti i broj administratora. ako je broj administratora jedan, onda se profil ne smije izbrisati.
       //ako je broj administratora više od jednog onda se taj administrator račun može izbrisati. 
$odgovor=$_POST['odgovor'];
if($odgovor=='yes'){

//ako je uloga korisnika administrator
if($_SESSION['role']=="Administrator"){
//pronađi administratora u bazi
$find_admin_nums_query="SELECT uloga FROM uloge WHERE uloga='Administrator'";
//izvrši query
$res=mysqli_query($dbc,$find_admin_nums_query);
//vrati broj redova
$numrows=$res->num_rows;
//ako je broj redova veći od 1 može se obrisati administratorski račun
if($numrows>1){
    $upit="DELETE FROM registration WHERE email ='$username'";
    $o=mysqli_query($dbc,$upit);
    if($o){
        echo "Profile deleted"."<a href='index.html'>Back to homepage</a>";
        mysqli_close($dbc);
    } else{
        echo "Delete failed.";
        mysqli_close($dbc);
    }
} else{
    //ispiši poruku da se ne može izbrisati račun jer ima samo jedan administrator
    echo "Account cannot be deleted. You are the only one admin available.";
}
}else{
    $upit="DELETE FROM registration WHERE email ='$username'";
    $o=mysqli_query($dbc,$upit);
    if($o){
        echo "Profile deleted"."<a href='index.html'>Back to homepage</a>";
        mysqli_close($dbc);
    } else{
        echo "Delete failed.";
        mysqli_close($dbc);
    }
}
}





?>
         </section>
    </div>
</body>
</html>