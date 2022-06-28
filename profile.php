<?php
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
    <link rel="stylesheet" href="css/stil.css" type="text/css" media="all">
</head>
<body>
    <div class="con">
        <nav>
        <a href="#" target="_self">Registation</a>
<a href="#" target="_self">Login</a>
<a href="logout.php" target="_self">Logout</a>
<a href="dodjeli_uloge.php" target="_self">Set user roles</a>
                <a href="feedback.php" target="_self">Add feedback</a>

        </nav>
        <section>
            <h2>Your profile</h2>
            <?php 
            include("dbconn.php");
            $sql="SELECT imageId, imageType, imageData FROM profilna WHERE email='$username'";
            $res=mysqli_query($dbc,$sql);
            while($row=mysqli_fetch_array($res)){
                   echo "<label>User image:</label><br>";
                   echo '<img src="data:'.$row['imageType'].';base64,'.base64_encode($row['imageData']).'" width="100" height="100"/>';
            }
            $sql2="SELECT fname,lname,sex,dateofbirth,cityofbirth,countryofbirth,pass,email,uloga FROM registration WHERE id='$id'";
            $t=mysqli_query($dbc,$sql2);
            while($o=mysqli_fetch_array($t)){
                ?>
                <form action="profile.php" method="post">
                    <label>First name:</label> <br>
                    <input type="text" name="firstname1" value="<?php echo $o['fname']; 
                    $fn=$o['fname'];?>"> <br>
                    <label>Last name:</label> <br>
                    <input type="text" name="lastname1" value="<?php echo $o['lname'];
                    $ln=$o['lname'];
                    ?>"> <br>
                    <label>Sex:</label> <br>
                    <input type="text" name="sex1" value="<?php echo $o['sex']; 
                    $s=$o['sex'];
                    ?>"> <br>
                    <label>Date of birth:</label> <br>
                    <input type="date" name="datum1" value="<?php echo $o['dateofbirth']; 
                    $d=$o['dateofbirth'];
                    ?>"> <br>
                    <label> City of birth:</label> <br>
                    <input type="text" name="cityofbirth1" value="<?php echo $o['cityofbirth'];
                    $c=$o['cityofbirth'];
                    ?>"> <br>
                    <label>Country of birth:</label> <br>
                    <input type="text" name="countryofbirth1" value="<?php echo $o['countryofbirth']; 
                    $co=$o['countryofbirth'];
                    ?>"> <br>
                    <label>Pass:</label> <br>
                    <input type="text" name="pass1" value="<?php echo $o['pass'];
                    $p=$o['pass'];
                    ?>"> <br>
                    <label>Email:</label> <br>
                    <input type="email" name="email1" value="<?php echo $o['email']; 
                    $e=$o['email'];
                    ?>"> <br>
                    <label>Role:</label> <br>
                    <input type="text" name="uloga1" value="<?php echo $o['uloga'];
                    $u=$o['uloga'];
                    ?>"> <br>
                  <?php 
                  $ul=$_SESSION[$o['uloga']];
                  if($ul=="Korisnik"){
                      
                      $_SESSION['username']=$_POST['email'];
                      $_SESSION['uloga']=$_POST[$ul];
                  }else if($ul=="Administrator"){
                      $_SESSION['username']=$_POST['email'];
                      $_SESSION['uloga']=$_POST[$ul];
                  }
                   }
                   
                   mysqli_close($dbc);
                  ?>
                  <input type="submit" value="Update">
                </form>
           
           <?php
                  include("dbconn.php");
                  $id1=$_SESSION['id'];
                  $firstname1=$_POST['firstname1'];
                  $lastname1=$_POST['lastname1'];
                  $sex1=$_POST['sex1'];
                  $datum1=$_POST['datum1'];
                  $cityofbirth1=$_POST['cityofbirth1'];
                  $countryofbirth1=$_POST['countryofbirth1'];
                  $pass1=$_POST['pass1'];
                  $email1=$_POST['email1'];
                  $uloga1=$_POST['uloga1'];
                  echo $id1;
                  echo $firstname1;
                  echo $lastname1;
                  echo $sex1;
                  echo $datum1;
                  echo $cityofbirth1;
                  echo $countryofbirth1;
                  echo $pass1;
                  echo $email1;
                  echo $uloga1;
                  if($_SERVER['REQUEST_METHOD']=='POST'){
                      if($firstname1!=$fn){
                          $query="UPDATE registration SET fname='$firstname1' WHERE id='$id'";
                          $r=mysqli_query($dbc,$query);
                          if($r){
                            echo "Promijenjeno je prvo ime";
                          }else{
                              echo "Error updating table";
                          }
                          
                      }
                      if($lastname1!=$ln){
                          $query="UPDATE registration SET lname='$lastname1' WHERE id='$id'";
                          $r=mysqli_query($dbc,$query);
                          if($r){
                            echo "Promijenjeno je prezime";
                          }else{
                              echo "Update failed.";
                          }
                         
                      }
                      if($sex1!=$s){
                          $query="UPDATE registration SET sex='$sex1' WHERE id='$id'";
                          $r=mysqli_query($dbc,$query);
                          if($r){
                            echo "Promijenjen je spol";
                          }else{
                              echo "Update failed.";
                          }
                          
                      }
                      if($datum1!=$d){
                          $query="UPDATE registration SET dateofbirth='$datum1' WHERE id='$id'";
                          $r=mysqli_query($dbc,$query);
                          if($r){
                            echo "Promijenjen je datum";
                          }else{
                              echo "Update failed.";
                          }
                          
                      }
                      if($cityofbirth1!=$c){
                          $query="UPDATE registration SET cityofbirth='$cityofbirth1' WHERE id='$id'";
                          $r=mysqli_query($dbc,$query);
                          if($r){
                            echo "Promijenjen je grad";
                          }else{
                              echo "Update failed";
                          }
                          
                      }
                      if($countryofbirth1!=$co){
                          $query="UPDATE registration SET countryofbirth='$countryofbirth1' WHERE id='$id'";
                          $r=mysqli_query($dbc,$query);
                          if($r){
                            echo "Promijenjena je država";
                          }else{
                              echo "Update failed";
                          }
                          
                      }
                      if($pass1!=$p){

                        $query="UPDATE registration SET pass='$pass1' WHERE id='$id'";
                        $r=mysqli_query($dbc,$query);
                        if($r){
                            echo "Promijenjena je šifra";
                        }else{
                            echo "Update failed";
                        }
                          
                      }
                      if($email1!=$e){
                        $query="UPDATE registration SET email='$email1' WHERE id='$id'";
                        $r=mysqli_query($dbc,$query);
                        if($r){
                            echo "Promijenjen je email";
                        }else{
                            echo "Update failed";
                        }
                          
                      }
                      if($uloga1!=$u){
                        $query="UPDATE registration SET uloga='$uloga1' WHERE id='$id'";
                        $r=mysqli_query($dbc,$query);
                        if($r){
                            echo "Promijenjena je uloga";
                        }else{
                            echo "Update failed";
                        }
                         
                      }
                      mysqli_close($dbc);
                  }else{
                      echo "";
                  }
                  

            ?>
        </section>

    </div>
</body>
</html>