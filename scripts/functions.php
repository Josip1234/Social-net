<?php 

//funkcija koja dohvaća trenutni datum 
//kao argument prima format datuma
//vraća trenutni datum temeljen na zadanom formatu korisnika
function dohvatiDanašnjiDatum($format){
    $date=date($format);
    return $date;
}
//funkcija koja dohvaća trenutno vrijeme
//kao argument prima format vremena
//vraća trenutno vrijeme temeljen na zadanom formatu korisnika
function dohvatiTrenutnoVrijeme($format){
    $time=date($format);
    return $time;
}
//funkcija koja će ispisati formu za prijavu korisnika
function ispisiFormuZaPrijavu(){
     echo  "<form class='forma' action=".$_SERVER['PHP_SELF']." method='post'>
          <label>Korisničko ime:</label>
          <label><input type='text' name='user' id='user'></label>
          <label>Lozinka:</label>
          <label><input type='password' name='pass' id='pass'></label>
          <label><input type='submit' value='Prijavi se'></label>
      </form>";
}

//funkcija za učitavanje podataka iz jsona
function UcitajPodatke($file){
$podaci=file_exists($file)?json_decode(file_get_contents($file),true):[];
return $podaci;
}

//funkcija koja će odjaviti korisnika uništavajući sesiju
//i vratiti će vrijeme u sekundama koliko je sesija trajala
function unistiSesiju(){
    $vrijeme="";
    $vrijeme=isset($_SESSION["login"]);
    unset($_SESSION["user"]);
    unset($_SESSION["login"]);
    session_unset();
    session_destroy();
    header("Location:pocetna.php");
    return $vrijeme;
}

//funkcija koja će računati vrijeme koliko je korisnik bio na stranici
function izracnajVrijeme($trenutnoVrijeme){
    //dodatni podaci koji će se ispisati u headeru
    if(isset($_SESSION["login"])){
       $rezultat=$trenutnoVrijeme-$_SESSION["login"];
       $rezultat_u_mnutama=round($rezultat/60,2);
       echo "<p>Korisnik je  prijavljen: ".$rezultat_u_mnutama." minuta.</p>";
    }
    
}

?>