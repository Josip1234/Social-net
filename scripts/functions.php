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


?>