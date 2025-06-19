<?php 
include "dbconn.php";
include "functions.php";
dohvati_listu_slika_iz_direktorija();
session_start();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
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
<a href="logout.php" target="_self">Logout</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Privacy, feedbacks</button>
    <div class="dropdown-content">
        <a href="privacy.php" target="_self" style="font-size: 12px;">Terms of privacy</a>
         
        <a href="feedback.php" target="_self">Add feedback</a>
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
    <a href="forum.php" target="_self" rel="noopener noreferrer">Forum</a>
    <a href="index.html" target="_self" rel="noopener noreferrer">Back to home page</a>
    </div>
  </div>
  <div class="dropdown">
    <button class="dropbtn">Photos</button>
    <div class="dropdown-content">
    <a href="print_profile_history.php" target="_self" rel="noopener noreferrer">Print profile history images</a>
    <a href="galerija.html" target="_blank" rel="noopener noreferrer">Photo gallery</a>
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
    <section id="valut">
        <iframe src="valutaV3.html" seamless></iframe>
    </section>
<div class="pravila">
<section><h2>Login here</h2>
<form action="login.php" method="post">
<label>Username as email:</label><br/>
<input type="email" name="username" maxlength="50" size="15" required autocomplete="off"/>
<br/>
<label>Password:</label><br/>
<input type="password" name="pass" required size="15" autocomplete="off"/>
<br/>
<input type="submit" value="Login"/>

</form>
<?php 

include("dbconn.php");
$username=$_POST['username'];

if($username!=''){
$pass=$_POST['pass'];

if($pass!=''){
$upit="SELECT id,email,pass FROM registration WHERE email='$username' AND pass='$pass'";
$r=mysqli_query($dbc,$upit);

$upit2="SELECT uloga FROM uloge WHERE email='$username'";
$re=mysqli_query($dbc,$upit2);


//dohvati broj redova iz sql upita iz tablice uloge
$row_cnt = $re->num_rows;

    //update za user rolu ako ne postoji za trenutnog korisnika ako je broj redova nula trebao bi unjeti korisnikovo ime i ulogu u tablice uloga
    if($row_cnt==0){
        $quer="INSERT INTO uloge(email,uloga) VALUES ('$username','Korisnik')";
        mysqli_query($dbc,$quer);
}

//traži ulogu korisnika u bazi 
while($rezultat=mysqli_fetch_array($re)){
        $role=$rezultat['uloga'];
        
}

//ako korisnik postoji dodaj sesiju roles dobivenu iz tablice uloga
while($res=mysqli_fetch_array($r)){
              if($username==$res['email']){


                if($pass==$res['pass']){

                        session_start();
                        $_SESSION['id']=$res['id'];
                        $_SESSION['username']=$res['email'];
                        $_SESSION['pass']=$res['pass'];
                    
                        $_SESSION['role']=$role;
                     
                        $_SESSION['login']=time();
                        header('Location:profile.php');
                }
              }
        
      
	
}
}
}
mysqli_close($dbc);

?>
</section>
</div>


<footer>
        <p id="datum"></p>
</footer>
</body>
</html>