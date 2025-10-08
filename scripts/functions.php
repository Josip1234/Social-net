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
    global $sakupljac_logova;
    global $res;
    $vrijeme="";
    $vrijeme=isset($_SESSION["login"]);
     $tmp=(isset($_SESSION["user"]))?$_SESSION["user"]:"";
    //echo ODJAVA.PODI.$tmp." ".date(CRO_TIMESTAMP_FORMAT);
    $sakupljac_logova[date(SQLTIMEST)]=ODJAVA.PODI.$tmp." ".date(CRO_TIMESTAMP_FORMAT);
    //echo PRIJAVLJEN.PODI.$tmp." ".izracnajVrijeme(time()).MIN;
   
     unset($_SESSION["user"]);
    unset($_SESSION["login"]);
    session_unset();
    session_destroy();
    header("Location:pocetna.php");
    return $vrijeme;
}

//funkcija koja će računati vrijeme koliko je korisnik bio na stranici
function izracnajVrijeme($trenutnoVrijeme){
    $rezultat=0.0;
    //dodatni podaci koji će se ispisati u headeru
    if(isset($_SESSION["login"])){
       $rezultat=$trenutnoVrijeme-$_SESSION["login"];
       $rezultat_u_mnutama=round($rezultat/60,2);
       echo "<p>Korisnik je  prijavljen: ".$rezultat_u_mnutama." minuta.</p>";
       $rezultat=$rezultat_u_mnutama;
    }
    return $rezultat;
}
//funkcija koja će ispisati formu za registraciju korisnika
function ispisiFormuZaRegistraciju(){
      echo "<form class='forma registracija' action='".$_SERVER["PHP_SELF"].'?akcija=registracija'."' method='post'>
        <label>Ime:</label>
        <label><input type='text' name='ime' id='ime' required></label>
        <label>Prezime:</label>
        <label><input type='text' name='prezime' id='prezime' required></label>
        <label for='telbroj'>Telefonski broj:</label>
        <label><input type='tel' name='telbroj' id='telbroj'></label>
        <label for='datum_rodjenja'>Datum rođenja:</label>
        <label><input type='date' name='datum_rodjenja' id='datum_rodjenja' required></label>
        <label for='mjesto_drzava'>Mjesto i država rođenja:</label>
        <label><input type='text' name='mjesto_drzava' id='mjesto_drzava' required></label>
      
        <label for='adresa'>Trenutna adresa prebivlišta:</label>
        <label><input type='text' name='adresa' id='adresa'></label>
        <label for='spol'>Odaberite spol:</label>
        <label><input type='radio' name='spol' id='muski' required>Muški 
         <input type='radio' name='spol' id='zenski'>Ženski
        </label>
        <label for='email'>Unesite email adresu:</label>
        <label><input type='email' name='email' id='email' required></label>
        <label for='sifra1'>Upišite lozinku:</label>
        <label><input type='password' name='lozinka1' id='lozinka1' required></label>
        <label for='sifra2'>Ponovite lozinku:</label>
        <label><input type='password' name='lozinka2' id='lozinka2' required></label>
        <label><input type='submit' value='Registracija' name='registracija'></label>
    </form>
    ";
}
//funkcija koja će ispisivati logove ne treba argumente
function ispisi_logove(){
    global $sakupljac_logova;
    foreach ($sakupljac_logova as $key => $value) {
             echo $key." ".$value."<br>";
        
       
    }
}
//funkcija koja će zapisivati logove u datoteku
//možemo napraviti da se kreira datoteka po današnjem datumu
//primjerice log_08-10-2025 mogli bi koristiti format date za to
//trebamo provjeru dali datoteka već postoji ako postoji pročitaj datoteku 
//dodaj u polje onda dodaj u to polje zapis i dodaj u json 
//inače napravi novi file i dodaj zapis
function zapisiLogUDatoteku($zapis,$datoteka){
if(!file_exists($datoteka)){
    file_put_contents($datoteka,json_encode([]));
}else{
   $podaci=json_decode(file_get_contents($datoteka),true);
}

    $podaci[]=[$zapis];
    $encode=json_encode($podaci,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents($datoteka, $encode);
}
?>