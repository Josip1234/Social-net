<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Socialnet</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/stil.css" rel="stylesheet" type="text/css" media="all">
    </head>
    <body>
    <div class="con">
        <nav>
   
        <a href="index.html" target="_blank">Back to main page</a>
        <a href="#" target="_blank">Login</a>
        <a href="privacy.php" target="_blank">Term of privacy</a>
        </nav>
    </div>
    <div class="pravila">
        <section>
            <h2>Register here</h2>
            <form action="registration.php" method="post">
            <label>First name:</label><br/>
<input type="text" name="fname" autocomplete="off" maxlength="50" size="17" required/><br/>
<label>Last name:</label><br/>
<input type="text" name="lname" autocomplete="off" maxlength="50" size="17" required/><br/>
<label>Sex:</label><br/>
<input type="radio" name="spol" value="muski" required>M 
<input type="radio" name="spol" value="zenski" required>Z 
<br/>
<label>Date of birth:</label><br/>
<input type="date" name="datum_rodjenja" required/><br/>
<label>City of birth:</label><br/>
<input type="text" name="city_of_birth" maxlength="50" size="17" autocomplete="off" required/><br/>
<label>Country of birth:</label><br/>
<input type="text" name="country_of_birth" maxlength="50" size="17" autocomplete="off" required /><br/>
<label>Pass:</label><br/>
<input type="password" name="pass" maxlength="50" size="17" required autocomplete="off" /><br/>
<label>Profile picture:</label><br/>
<input type="file" name="slika" required><br/> 
<br/>
<input type="submit" value="Register"/>
            </form>
            <?php 
include("dbconn.php");
$firstname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['fname'])));
if($firstname!=''){
    $lastname=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['lname'])));
    if($lastname!=''){
        $sex=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['spol'])));
        if($sex!=''){
            $datum_rodjenja=$_POST['datum_rodjenja'];
            if($datum_rodjenja!=''){
                $city=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['city_of_birth'])));
                if($city!=''){
                    $country=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['country_of_birth'])));
                    if($country!=''){
                        $pass=mysqli_real_escape_string($dbc,trim(strip_tags($_POST['pass'])));
                        if($pass!=''){
                            $slika=$_POST['slika'];
                            if($slika!=''){
                                $query="INSERT INTO registration(fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,profilepicture) VALUES '$firstname','$lastname','$sex','$datum_rodjenja','$city','$country','$pass','$slika')";
                                mysqli_query($dbc,$query);
                                mysqli_close($dbc);
                                if($query){
                                    header('Location:index.html');
                                }else{
                                    die('Error! Cannot add informations!');
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

            ?>
        </section>
    </div>
    </body>
</html>