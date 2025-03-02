<?php

use Dom\Mysql;

$role="Administrator";
session_start();
if(!isset($_SESSION['username'])){
    header('Location: login.php');
}else{
    if($_SESSION['role']!=$role){
        header('Location:profile.php');
    }else{
        $_SESSION['login']=time();
    }
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
<nav>
    <a href="registration.php" target="_blank" rel="noopener noreferrer">Registration</a>
    <a href="login.php" target="_blank" rel="noopener noreferrer">Login</a>
    <?php
    if($_SESSION['role']=="Administrator"){
echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer'>Trenutni feedbackovi</a>";
}
?>
    <a href="profile.php" target="_blank" rel="noopener noreferrer">Profile of user</a>
    <a href="logout.php" target="_blank" rel="noopener noreferrer">Logout</a>
    <a href="feedback.php" target="_blank" rel="noopener noreferrer">Add feedback</a>
</nav>
    </div>
    <div class="pravila">
<section>
    <h1>Lista korisnika koja nemaju ulogu u bazi podataka a nisu se ulogirali prvi put</h1>
    <?php 
include("dbconn.php");
//selektiraj samo korisnike koje nemaju uloge u tablici uloga MOĆI ĆEMO KORISTITI I ZA SELECT U OPTION VALUES
$sql="SELECT fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email FROM registration WHERE registration.email NOT IN (SELECT DISTINCT uloge.EMAIL FROM uloge)";
$result=mysqli_query($dbc,$sql);
while($res=mysqli_fetch_array($result)){
    echo $res['fname']."<br/>";
    echo $res['lname']."<br/>";
    echo $res['sex']."<br/>";
    echo $res['dateofbirth']."<br/>";
    echo $res['cityofbirth']."<br/>";
    echo $res['countryofbirth']."<br/>";
    echo $res['pass']."<br/>";
    echo $res['email']."<br/>";
    echo "<br/>";
}

    ?>
</section>
    </div>

    <div id="dodjela_uloga">
        <section>
            <h2>Dodjeli uloge:</h2>
            <form action="dodjeli_uloge.php" method="post">
                <label for="selectko">Selektiraj korisnika za kojeg želiš dodjeliti ulogu:</label> <br>
                <select name="selectko" id="selectko">
                       <?php
                    $exe_query=mysqli_query($dbc,$sql);
                    while($exe=mysqli_fetch_array($exe_query)){
                        echo "<option value='".$exe['email']."'>".$exe['email']."</option>";
                    }
                    ?>
                        
                


            
</select><br>
                
                <label for="selektiraj">Dostupne uloge:</label><br>
                <select name="selektiraj" id="selektiraj">
                    <option value="Administrator">Administrator</option>
                    <option value="Korisnik">Korisnik</option>
                    <option value="Banovani korisnik">Banovani korisnik</option>
                </select> <br>
               <label for="s">Uloga korisnika:</label>
               <input type="text" name="s" id="s" value="Administrator, korisnik ili banovani korisnik" required>
                <input type="submit" value="Dodjeli ulogu">
            </form>
            <?php 
             $email=$_POST['user'];
             $s=$_POST['s'];
             if($email!=''){
                if($s!=''){
                    if($s=="Administrator"){}
                    else if($s=="Korisnik"){}
                    else if($s=="Banovani korisnik"){}
                    else{
                        die('Invalid role');
                    };
                }
             }else{
                die("Email missing");
             }


?>
        </section>

    </div>
</body>
</html>