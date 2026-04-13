<?php 
include "dbconn.php";
session_start();
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
function provjeri_dali_postoji_u_bazi(string $username, string $password){
    global $dbc;
    $query="SELECT email from registration where email='$username'";
    $pass_hash="SELECT pass from registration where email='$username'";
    $q=mysqli_query($dbc,$query);
    $q2=mysqli_query($dbc,$pass_hash);
    if($res=mysqli_fetch_array($q)){
        if($res["email"]==$username){
            if($res2=mysqli_fetch_array($q2)){
                //verifikacija passworda trebamo plain text i hash iz baze
                
                if(password_verify($password,$res2["pass"])){
                          
                        $_SESSION["username"]=$username;
                        $_SESSION["pass"]=password_hash($password,PASSWORD_DEFAULT);
                        $_SESSION["loggedin"]=1;
                        $_SESSION["isLogged"]=time();
                        echo "User has been successfully logged in.";
                        header("Location: index.php");
                }else{
                     $_SESSION["loggedin"]=0;
                    die("Wrong password. Please, try again.");
                }
            }
           
        }
    }else{
        $_SESSION["loggedin"]=0;
      
        die("Username does not exist in database. Registration is needed.");
        
    }
}