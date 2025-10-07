<?php  include "zaglavlje.php"; ?>
    <div id="sadrzaj">
            <?php include "navigacija.php"; ?>
             <?php 
              $vrijeme="";
              (isset($_GET["akcija"]))?(($_GET["akcija"]==="prijava")?ispisiFormuZaPrijavu():""):"";
              (isset($_GET["akcija"]))?(($_GET["akcija"]==="odjava")?$vrijeme=unistiSesiju():""):"";
              (isset($_GET["akcija"]))?(($_GET["akcija"]==="registracija")?ispisiFormuZaRegistraciju():""):"";
               
              //ako su postani podaci i ako se u urlu nalazi akcija
              if($_SERVER["REQUEST_METHOD"]=="POST" && isset($_GET["akcija"])){
                //ako je akcija login
                if($_GET["akcija"]==="prijava"){
                 if(!empty($_POST["user"]) && !empty($_POST["pass"])){
                    $user=$_POST["user"];
                    $password=$_POST["pass"];
                    $podaci=UcitajPodatke("files/users.json");
                    //pretraži podatke u jsonu ako postoji korisničko ime i lozinka startaj sesiju
                    //ako ne javi grešku
                    foreach ($podaci as $key => $value) {
                       if(in_array($user,$value) && $user===$value["user"]){
                        if(in_array($password,$value) && $password===$value["pass"]){
                            $_SESSION["login"]=time();
                            $_SESSION["user"]=$user;
                            echo PRIJAVA.PODI.USER." ".date(CRO_TIMESTAMP_FORMAT);
                            header("Location: pocetna.php");
                            break;
                        }else{
                            echo "<p class='error'>Wrong password!</p>";
                            echo GRESKA." ".date(CRO_TIMESTAMP_FORMAT);
                        }
                    }else{
                        echo "<p class='error'>Wrong username!</p>";
                         echo GRESKA." ".date(CRO_TIMESTAMP_FORMAT);
                     
                    }
                    }
                
                 }else{
                    echo "<p class='error'>Podaci nisu valjani.</p>";
                     echo GRESKA." ".date(CRO_TIMESTAMP_FORMAT);
                 }
                
                } //ako akcija nije za login
                else{
                    echo "<p class='error'>Niste kliknuli na obrazac!</p>";
                    echo NOTFORM." ".date(CRO_TIMESTAMP_FORMAT);
                }
              }
               
             
             
             ?>
    </div>

<?php include "podnozje.php";?>