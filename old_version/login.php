<?php 
include "dbconn.php";

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

<a href="registration.php" target="_blank">Registation</a>
<a href="index.html" target="_blank">Back to main page</a>
<a href="privacy.php" target="_blank">Terms of privacy</a>
<a href="trenutnifeedback.php" target="_blank">Feedbacks-only for admins</a>
<a href="profile.php" target="_blank" rel="noopener noreferrer">Profile of user</a>
<a href="logout.php" target="_blank" rel="noopener noreferrer">Logout</a>
<?php 

if($_SESSION['role']=="Administrator"){
echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>User roles</a>";
} 

if($_SESSION['role']=="Administrator"){
echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer'>Trenutni feedbackovi</a>";
}
?>
<a href="feedback.php" target="_blank" rel="noopener noreferrer">Add feedback</a>
</nav>
</div>
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



</body>
</html>