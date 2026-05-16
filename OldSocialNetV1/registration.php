<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width,initial-scale=1">
<title>Socialnet</title>
<link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
<?php include "functions.php"; echo jsIncludes(); ?>
</head>

<?php  echo printBodyOnMouseOverAndOnLoad(); ?>

<div class="con">
<nav>

<?php require_once "navigacija.php"; 
require_once "dbconn.php";
?>

</nav>
</div>
<?php 
echo dropdownMenu();
echo printCalendar();
echo printPictures();
echo printVideos();

?>
<div class="pravila">
<section><h2>Register here</h2>
<form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
<label>First name:</label><br/>
<input type="text" name="fname" autocomplete="off" maxlength="50" size="17" required/><br/>
<label>Last name:</label><br/>
<input type="text" name="lname" autocomplete="off" maxlength="50" size="17" required/><br/>
<label id="r">Sex:</label><br/>
<input type="radio" name="spol" value="m" checked required>M 
<input type="radio" name="spol" value="z">Z 
<br/>
<label>Date of birth:</label><br/>
<input type="date" name="datum_rodjenja" required/><br/>
<label>City of birth:</label><br/>
<input type="text" name="city_of_birth" maxlength="50" size="17" autocomplete="off"/><br/>
<label>Country of birth:</label><br/>
<input type="text" name="country_of_birth" maxlength="50" size="17" autocomplete="off" /><br/>
<label>Pass:</label><br/>
<input type="password" name="pass" maxlength="50" size="17" required autocomplete="off" /><br/>

<label for="email">Email:</label> <br>
<input type="email" name="email" id="email" size="17" required>
<br>
<input type="submit" value="Register"/>
</form>
<?php 
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $numberOfErrors=0;
    $fname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST["fname"])));
    if($fname===''){
       echo "First name cannot be empty!";
       $numberOfErrors++;
    }
     $lname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST["lname"])));
     if($lname===''){
        echo "Last name cannot be empty!";
        $numberOfErrors++;
     }
     $sex=$_POST["spol"];
     if($sex===''){
        echo "Sex cannot be empty!";
        $numberOfErrors++;
     }

     $dateOfBirth=$_POST["datum_rodjenja"];
     //trenutni datum
    $currentDate=date("Y-m-d");
     //kopiramo datum u varijablu
    //promijenimo format
     $kopijaRodjenja=date("Y-m-d",strtotime($dateOfBirth));
    //izračunamo razliku datuma
    $razlika=strtotime($currentDate)-strtotime($kopijaRodjenja);
    //uzmi trenutnu godinu
    $trenutna_godina=date("Y");
    //uzmi godinu od datuma rođenja možemo uzeti i kopiju
    $godina_datumar=date("Y",strtotime($kopijaRodjenja));
    //izračunaj razliku godina
    $razlikaGodina=$trenutna_godina-$godina_datumar;
    //ako datum rođenja nije prazan i ako je razlika datzuma različita od nule (nije današnji datum)
    //ako je razlika veća od nule (nije budući datum) i ako je razlika godina veća ili jednaka od 18 
    //može se dalje inače javi grešku ne mogu se registrirati osobe manje od 18 godina
    if($dateOfBirth === '' && $razlika===0 && $razlika<0 && $razlikaGodina<18){
          echo "Date of birth cannot be empty, date cannot be today, date cannot be future date, 
          person must have 18+ to register.";   
          $numberOfErrors++;      
    }
    
       $cityOfBirth=mysqli_real_escape_string($dbc,trim(strip_tags($_POST["city_of_birth"])));
                if($cityOfBirth===''){
                   echo "City of birth cannot be empty.";
                   $numberOfErrors++;
                }
     $countryOfBirth=mysqli_real_escape_string($dbc,trim(strip_tags($_POST["country_of_birth"])));
     if($countryOfBirth===''){
        echo "Country of birth is required!";
        $numberOfErrors++;
     }
    
     $pass=mysqli_real_escape_string($dbc,trim(strip_tags($_POST["pass"])));
     if($pass===''){
        echo "Password is required.";
        $numberOfErrors++;
     }
     if(strlen($pass)<8){
        echo "Password must have at least 8 characters.";
        $numberOfErrors++;
     }
     //ako nema grešaka može unos u tablicu

     $email=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['email'])));
     if($email===''){
      echo "Email is required";
      $numberOfErrors++;
     }

     if($numberOfErrors===0){
        //for inserting new default user role for registered user need next user id which will be inserted first in 
        //registration table
        $nextIdSql="select max(id)+1 as id from registration";
        $stmt=mysqli_query($dbc,$nextIdSql);
        $resId=$stmt->fetch_assoc();
        $id=$resId["id"];

        $query="INSERT INTO registration (fname,lname,sex,dateOfBirth,cityOfBirth,countryOfBirth,pass,email)
        values ('$fname','$lname','$sex','$dateOfBirth','$cityOfBirth','$countryOfBirth','" . password_hash($pass, PASSWORD_DEFAULT) . "','$email')";
        mysqli_query($dbc,$query);
        $defaultRole="Korisnik";
        if($query){
            //INSERT DEFAULT ROLE in table ULOGE when registration query was executed
            $sql="INSERT INTO uloge(user_id,uloga) values ('$id','$defaultRole')";
            mysqli_query($dbc,$sql);
            if($sql){
                 
                  login_without_redirection($email,$pass);
                   mysqli_close($dbc);
               header('Location: profilna.php?email='.$email);
            }
         
        }else{
            die("Cannot add information in tables. Please check your connection.");
                mysqli_close($dbc);
        }
    
     }


}


?>
</section>
</div>


<?php 
echo printFooter();
?>
</body>
</html>