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

?>