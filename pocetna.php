<?php  include "zaglavlje.php"; ?>
    <div id="sadrzaj">
            <?php include "navigacija.php"; ?>
             <?php 
              $vrijeme="";
              (isset($_GET["akcija"]))?(($_GET["akcija"]==="prijava")?ispisiFormuZaPrijavu():""):"";
              (isset($_GET["akcija"]))?(($_GET["akcija"]==="odjava")?$vrijeme=unistiSesiju():""):"";
               
              if($_SERVER["REQUEST_METHOD"]=="POST"){
                 if(!empty($_POST["user"]) && !empty($_POST["pass"])){
                    $user=$_POST["user"];
                    $password=$_POST["pass"];
                    $podaci=UcitajPodatke("files/users.json");
                    //pretraži podatke u jsonu ako postoji korisničko ime i lozinka startaj sesiju
                    //ako ne javi grešku
                    foreach ($podaci as $key => $value) {
                       if(in_array($user,$value)){
                        if(in_array($password,$value)){
                            $_SESSION["login"]=time();
                            $_SESSION["user"]=$user;
                            header("Location: pocetna.php");
                            break;
                        }else{
                            echo "<p class='error'>Wrong password!</p>";
                            ispisiFormuZaPrijavu();
                            break;
                        }
                    }else{
                        echo "<p class='error'>Wrong username!</p>";
                        ispisiFormuZaPrijavu();
                        break;
                    }
                    }
                
                 }else{
                    echo "<p class='error'>Podaci nisu valjani.</p>";
                    ispisiFormuZaPrijavu();
                 }
              }

             
             ?>
    </div>
<?php include "podnozje.php"; ?>