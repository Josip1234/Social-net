<?php 
include "dbconn.php";
//ova funkcija bi trebala riješiti ponovni unos nakon refresh stranice
//ova funkcija je višak možda će biti potrebna pa ćemo je ostaviti ovdje
function provjeri_prethodnog(string $fname,string $lname,string $suggestions):bool{
    include "dbconn.php";
    $postoji=false;
    $sql1="select suggestion from kvaliteta where id=id-1";
    mysqli_query($dbc,$sql1);
    if($suggestions==$sql1){
        $sql2="DELETE FROM kvaliteta where id=id";
        mysqli_query($dbc,$sql2);
        $postoji=true;
        return $postoji;
    }
    return $postoji;
}