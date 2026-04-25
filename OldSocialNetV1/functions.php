<?php 
include "dbconn.php";
//if session did not started
if(session_status()===PHP_SESSION_NONE){
    session_start();
}

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
    $query="SELECT registration.id,email,uloga from registration inner join uloge on registration.id=uloge.user_id where email='$username'";
    $pass_hash="SELECT pass from registration where email='$username'";
    $role="";
    $q=mysqli_query($dbc,$query);
    $q2=mysqli_query($dbc,$pass_hash);
    if($res=mysqli_fetch_array($q)){
        if($res["email"]==$username){
            if($res2=mysqli_fetch_array($q2)){
                //verifikacija passworda trebamo plain text i hash iz baze
                
                if(password_verify($password,$res2["pass"])){
                        $role=$res['uloga'];
                        $_SESSION["id"]=$res['id'];
                        $_SESSION["username"]=$username;
                        $_SESSION["pass"]=password_hash($password,PASSWORD_DEFAULT);
                        $_SESSION["loggedin"]=1;
                        $_SESSION["role"]=$role;
                        $_SESSION["isLogged"]=time();
                        echo "User has been successfully logged in.";
                        header("Location: profile.php");
                }else{
                     $_SESSION["loggedin"]=0;
                     print('<a href="index.php">Back to homepage</a><br>');
                    die("Wrong password. Please, try again.");
                    
                }
            }
           
        }
    }else{
        $_SESSION["loggedin"]=0;
      
        die("Username does not exist in database. Registration is needed.");
        
    }
}


function loggedUsersOnly(){
    if(!isset($_SESSION["username"])){
	header('Location: login.php');
}
}

function returnUrls($userId):array{
    $urls=[];
     $urls["logout"]='<a href="logout.php" target="_self">Logout</a>';
     $urls["profile"]='<a href="profile.php" target="_self">User profile</a>'; 
    global $dbc;

   $sql="SELECT u.uloga from uloge u where user_id='$userId'";
   $stmt=mysqli_query($dbc,$sql);
   $query=mysqli_fetch_assoc($stmt);
   if($query["uloga"]==="Administrator"){
        $urls["currentFeedbacks"]='<a href="trenutnifeedback.php" target="_self">Current feedbacks</a>';
        $urls["userRoles"]='<a href="dodjeli_uloge.php" target="_self">Assign user roles</a>';    
   }
   return $urls;
}

function logout(){
    $msg="Logged out.";
    session_destroy();
    header("Location: index.php?msg=".$msg);
}


function login_without_redirection(string $username, string $password){
    global $dbc;
    $query="SELECT registration.id,email,uloga from registration inner join uloge on registration.id=uloge.user_id where email='$username'";
    $pass_hash="SELECT pass from registration where email='$username'";
    $role="";
    $q=mysqli_query($dbc,$query);
    $q2=mysqli_query($dbc,$pass_hash);
    if($res=mysqli_fetch_array($q)){
        if($res["email"]==$username){
            if($res2=mysqli_fetch_array($q2)){
                //verifikacija passworda trebamo plain text i hash iz baze
                
                if(password_verify($password,$res2["pass"])){
                        $role=$res['uloga'];
                        $_SESSION["id"]=$res['id'];
                        $_SESSION["username"]=$username;
                        $_SESSION["pass"]=password_hash($password,PASSWORD_DEFAULT);
                        $_SESSION["loggedin"]=1;
                        $_SESSION["role"]=$role;
                        $_SESSION["isLogged"]=time();
         
                }else{
                     $_SESSION["loggedin"]=0;
                     print('<a href="index.php">Back to homepage</a><br>');
                    die("Wrong password. Please, try again.");
                    
                }
            }
           
        }
    }else{
        $_SESSION["loggedin"]=0;
      
        die("Username does not exist in database. Registration is needed.");
        
    }
}