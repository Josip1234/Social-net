<?php 
include "dbconn.php";
session_start();
if(!isset($_SESSION['username'])){
    header('Location: registration.php');
}else{
    if($_SESSION['role']!="Administrator"){
        $id=$_SESSION['id'];
        $username=$_SESSION['username'];
        $_SESSION['login']=time();
	}else{
        $id=$_SESSION['id'];
        $username=$_SESSION['username'];
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
    <a href="logout.php" target="_blank" rel="noopener noreferrer">Logout</a>
    <?php 

if($_SESSION['role']=="Administrator"){
echo "<a href='dodjeli_uloge.php' target='_blank' rel='noopener noreferrer'>User roles</a>";
echo "<a href='update_roles_for_all.php' target='_blank' rel='noopener noreferrer'>Update all roles</a>";
}
?>
<?php 

if($_SESSION['role']=="Administrator"){
echo "<a href='trenutnifeedback.php' target='_blank' rel='noopener noreferrer'>Trenutni feedbackovi</a>";
}
?>
<a href="feedback.php" target="_blank" rel="noopener noreferrer">Feedback</a>
<a href="terminirajprofil.php" target="_blank" rel="noopener noreferrer">Delete profile</a>
<a href="privacy.php" target="_blank" rel="noopener noreferrer">Terms of privacy</a>
<a href="profile.php" target="_blank" rel="noopener noreferrer">Profile of user</a>
<a href="profilna.php" target="_blank" rel="noopener noreferrer">Add profile picture</a>
</nav>
    </div>
    <div class="pravila">
<section>
    <h2>Your profile</h2>
   <!-- <img src="<?php ?>" alt="profile_picture"><br/>-->
    <?php //samo ispisujemo podatke ovdje trebamo stvoriti gumb za update, podaci se ispisuju prema id-u korisnika koji je trenutno ulogiran  ?>
    <?php  
   
    $sql="SELECT imageId, imageType, imageData FROM profilna WHERE email = '$username'";
    $res=mysqli_query($dbc,$sql);
    while($ro=mysqli_fetch_array($res)){
        echo "<label>User image:</label><br/>";
        echo '<img src="data:'.$ro['imageType'].';base64,'.base64_encode($ro['imageData']).'"width="100" height="100" />';
    }
    $sql2="SELECT fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email FROM registration WHERE email='$username'";
    $t=mysqli_query($dbc,$sql2);
    $sql3="SELECT uloga FROM uloge WHERE email='$username'";
    $role=mysqli_query($dbc,$sql3);
    while($o=mysqli_fetch_array($t)){
        $fname=$o['fname'];
        $lname=$o['lname'];
        $sex=$o['sex'];
        $dtb=$o['dateofbirth'];
        $ctb=$o['cityofbirth'];
        $coub=$o['countryofbirth'];
        $sif=$o['pass'];
        $e=$o['email'];
       
    }
    while($row=mysqli_fetch_array($role)){
      $u=$row['uloga'];
     
    }
    ?>
    <form action="profile.php" method="post">
        <label for="fname">First name:</label><br>
        <input type="text" name="fname1" id="fname" value="<?php echo $fname;  ?>"> <br>
        <label for="lname">Last name:</label> <br>
        <input type="text" name="lname1" id="lname" value="<?php echo $lname;  ?>"> <br>
        <label for="sex">Sex:</label><br>
        <input type="text" name="sex1" id="sex" value="<?php echo $sex; ?>" readonly> <br>
        <label for="dateofbirth">Date of birth:</label> <br>
        <input type="date" name="dateofbirth1" id="dateofbirth" value="<?php echo $dtb; ?>" readonly> <br>
        <label for="cityofbirth">City of birth:</label> <br>
        <input type="text" name="cityofbirth1" id="cityofbirth" value="<?php echo $ctb; ?>" readonly> <br>
        <label for="countryofbirth">Country of birth:</label><br>
        <input type="text" name="countryofbirth1" id="countryofbirth" value="<?php echo $coub; ?>" readonly> <br>
        <label for="pass">Pass:</label> <br>
        <input type="text" name="pass1" id="pass" value="<?php echo $sif; ?>"> <br>
        <label for="email">Email:</label><br>
        <input type="email" name="email1" id="email" value="<?php echo $e; ?>"> <br>
        <label for="role">Role</label> <br>
        <input type="text" name="uloga1" id="uloga" value="<?php
        echo $u;
        ?>" readonly><br>
        <input type="submit" value="Update">
    </form>
    <?php
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $id1=$_SESSION['id'];
        $firstname1=$_POST['fname1'];
        $lname1=$_POST['lname1'];
        //$sex1=$_POST['sex1']; isto kao i za datum poseban mail ili request za promijenu spola
        //$datum1=$_POST['datum1']; datum rođenja se neće ažurirati
        //za ažuriranje datuma bi trebalo poslati email administratoru
        //ili poseban dokument request ticket
        //$cityofbirth1=$_POST['cityofbirth1'];
        //$countryofbirth1=$_POST['countryofbirth1']; grad i zemlju isto nećemo ažurirati
        $pass1=$_POST['pass1'];
        $email1=$_POST['email1'];
        //$uloga1=$_POST['uloga1']; za promijenu uloge isto slati zahtjev, čak i kao administrator

        if($firstname1!=$fname){
            $q1="UPDATE registration SET fname='$firstname1' WHERE email='$e'";
            $e1=mysqli_query($dbc,$q1);
            if(!$e1){
                echo "Greška pri ažuriranja imena.";
             
            } else{
                echo "Promijenjeno je ime";
                //za refresh podataka na stranici
                header('Location: profile.php');
            }
        }
        if($lname1!=$lname){
            $q2="UPDATE registration SET lname='$lname1' WHERE email='$e'";
            $e2=mysqli_query($dbc,$q2);
            if(!$e2){
                echo "Greška pri ažuriranju prezimena.";
             
            } else{
                echo "Promijenjeno je prezime.";
                //za refresh podataka na stranici
                header('Location: profile.php');
            }
            
        }
        /*if($sex1!=$sex){
            echo "Promjenjen je spol.";
        }*/ //kao i datum rođenja ne ažurirati
        //provjera datuma je bug 
        //možda treba i izbaciti s obzirom da je datum rođenja.
        /*if($dateofbirth1!=$dtb){
            echo "Promijenjen je datum.";
        }*/ 
        //datum nećemo mijenjati
       /* if($cityofbirth1!=$ctb){
            $q3="UPDATE registration SET cityofbirth='$cityofbirth1' WHERE email='$e'";
            $e3=mysqli_query($dbc,$q3);
            if(!$e3){
                echo "Greška pri ažuriranju grada.";
             
            } else{
                echo "Promijenjen je grad.";
                //za refresh podataka na stranici
                header('Location: profile.php');
            }
            
        }*/
        /*if($countryofbirth1!=$coub){
            echo "Promijenjena je država.";
        }*/ //država rođenja isto kao i spol i datum i grad rođenja
        //kod promijene pifre i emaila potrebno se je odjaviti
        if($pass1!=$sif){
            $q3="UPDATE registration SET pass='$pass1' WHERE email='$e'";
            $e3=mysqli_query($dbc,$q3);
            if(!$e3){
                echo "Greška pri ažuriranju šifre.";
             
            } else{
                echo "Promijenjena je šifra.";
                //za refresh podataka na stranici
                //kada se šifra promijenila trebamo se odjaviti
                header('Location: logout.php');
            }
           
        }
        if($email1!=$e){
            $q4="UPDATE registration SET email='$email1' WHERE email='$e'";
            $e4=mysqli_query($dbc,$q4);
            if(!$e4){
                echo "Greška pri ažuriranju email adrese.";
             
            } else{
                echo "Promijenjena je email adresa.";
                //za refresh podataka na stranici
                //kada se šifra promijenila trebamo se odjaviti
                session_unset();
                session_destroy();
                header('Location: logout.php');
            }
            
        }
        /*if($uloga1!=$u){
            echo "Promijenjena je uloga.";
        }*///slanje requesta kao i kod datum , držae grada rođenja i spola bez obzira na ulogu


    }
    
    mysqli_close($dbc);
    ?>
    
</section>
    </div>
</body>
</html>