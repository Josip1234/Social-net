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
                    //registriraj i upiši vrijeme logiranja u log
                     $sakupljac_logova[date(SQLTIMEST)]=INFO." Vrijeme prijave".PODI.$user;
                   zapisiLogUDatoteku($sakupljac_logova,LOGFILE);
                    //pretraži podatke u jsonu ako postoji korisničko ime i lozinka startaj sesiju
                    //ako ne javi grešku
                    foreach ($podaci as $key => $value) {
                       if(in_array($user,$value) && $user===$value["user"]){
                        if(in_array($password,$value) && $password===$value["pass"]){
                            $_SESSION["login"]=time();
                            $_SESSION["user"]=$user;
                            $sakupljac_logova[date(SQLTIMEST)]=PRIJAVA.PODI.$user." ".date(CRO_TIMESTAMP_FORMAT);
                            header("Location: pocetna.php");
                            break;
                        }else{
                            echo "<p class='error'>Wrong password!</p>";
                             $sakupljac_logova[date(SQLTIMEST)]=GRESKA." Pogrešan password! ".date(CRO_TIMESTAMP_FORMAT);
                        }
                    }else{
                        echo "<p class='error'>Wrong username!</p>";
                           $sakupljac_logova[date(SQLTIMEST)]=GRESKA." Pogrešan username! ".date(CRO_TIMESTAMP_FORMAT);
                     
                    }
                    }
                
                 }else{
                    echo "<p class='error'>Podaci nisu valjani.</p>";
                       $sakupljac_logova[date(SQLTIMEST)]=GRESKA." Podaci nisu valjani. ".date(CRO_TIMESTAMP_FORMAT);
                 }
                
                } else if($_GET["akcija"]!="prijava"){
                    echo "<p class='error'>Niste kliknuli na obrazac!</p>";
                      $sakupljac_logova[date(SQLTIMEST)]=NOTFORM." ".date(CRO_TIMESTAMP_FORMAT);
                }
              }
               
            
             
             ?>
    </div>

<?php include "podnozje.php";?>