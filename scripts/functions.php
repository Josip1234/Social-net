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
     echo  "<form class='forma' action=".$_SERVER['PHP_SELF'].'?akcija=prijava'." method='post'>
          <label>Korisničko ime:</label>
          <label><input type='text' name='user' id='user'></label>
          <label>Lozinka:</label>
          <label><input type='password' name='pass' id='pass'></label>
          <label><input type='submit' value='Prijavi se' name='prijava'></label>
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
//funkcija koja će ispisati formu za registraciju korisnika
function ispisiFormuZaRegistraciju(){
      echo "<form action='".$_SERVER["PHP_SELF"]."' method='post'>
        <label>Ime:</label>
        <label><input type='text' name='ime' id='ime'></label>
        <label>Prezime:</label>
        <label><input type='text' name='prezime' id='prezime'></label>
        <label for='telbroj'>Telefonski broj:</label>
        <label><input type='tel' name='telbroj' id='telbroj'></label>
        <label for='datum_rodjenja'>Datum rođenja:</label>
        <label><input type='date' name='datum_rodjenja' id='datum_rodjenja'></label>
        <label for='mjesto_drzava'>Mjesto i država rođenja:</label>
        <label><input type='text' name='mjesto_drzava' id='mjesto_drzava'></label>
        <label for='zavrsena_skola'>Završene škole: (opcionalno)</label>
        <label><input type='checkbox' name='zavrsena_skola' id='zavrsena_skola' value='Osnovna škola'>Osnovna škola
        <input type='checkbox' name='zavrsena_skola' id='zavrsena_skola' value='Srednja škola - strukovna'>Srednja strukovna škola 
        <input type='checkbox' name='zavrsena_skola' id='zavrsena_skola' value='Srednja škola - gimnazija'>Gimnazija
        <input type='checkbox' name='zavrsena_skola' id='zavrsena_skola' value='Preddiplomski studij'>Pred diplomski studij
        <input type='checkbox' name='zavrsena_skola' id='zavrsena_skola' value='Diplomski studij'>Diplomski studij
        </label>
        <label for='adresa'>Trenutna adresa prebivlišta:</label>
        <label><input type='text' name='adresa' id='adresa'></label>
        <label for='spol'>Odaberite spol:</label>
        <label><input type='radio' name='spol' id='muski'>Muški 
         <input type='radio' name='spol' id='zenski'>Ženski
        </label>
        <label for='email'>Unesite email adresu:</label>
        <label><input type='email' name='email' id='email'></label>
        <label for='sifra1'>Upišite lozinku:</label>
        <label><input type='password' name='lozinka1' id='lozinka1'></label>
        <label for='sifra2'>Ponovite lozinku:</label>
        <label><input type='password' name='lozinka2' id='lozinka2'></label>
        <label><input type='submit' value='Registracija' name='registracija'></label>
    </form>
    ";
}

?>