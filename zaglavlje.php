<?php 
include "scripts/functions.php";
include "konstante/konstante.php";
if(session_status()===PHP_SESSION_NONE){
    session_start();
}
$sakupljac_logova=array();
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drustvena mreza</title>
    <link rel="stylesheet" href="styles/style.css">
    <script src="script/social.js"></script>
</head>
<body>
<header>
     <?php 
         //ispiši vrijeme kad se korisnik ulogirao i trenutno vrijeme iz sesije samo u slučaju ako je korisnik logiran tj ako
         //sesija postoji
         if(isset($_SESSION["login"]) && isset($_SESSION["user"])){
            echo "<p>Vrijeme prijave:".date(CRO_TIME_FORMAT,$_SESSION["login"])."</p>";
              $sakupljac_logova[date(SQLTIMEST)]=INFO." Vrijeme prijave".PODI.$_SESSION["user"];
              zapisiLogUDatoteku($sakupljac_logova,LOGFILE);
            
         }else{
            echo  "<p>Nema prijavljenog korisnika.</p>";
           
         }
     
     ?>
</header>
