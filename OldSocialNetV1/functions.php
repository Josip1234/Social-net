<?php 
include "dbconn.php";
//if session did not started
if(session_status()===PHP_SESSION_NONE){
    session_start();
}
//function for checking if there is user role 
//we already have this in dodjeli_uloge.php 
function check_if_user_already_have_role(int $userId,string $uloga):bool{
    global $dbc;
    $haveRole=true;
    $sql="SELECT count(id) as Res FROM uloge u where user_id=$userId and uloga=$uloga";
    $stmt=mysqli_query($dbc,$sql);
    $res=$stmt->fetch_assoc();
    if((int)$res["res"]===0){
        $haveRole=false;
    }
    return $haveRole;
}

//ova funkcija bi trebala riješiti ponovni unos nakon refresh stranice
//ova funkcija je višak možda će biti potrebna pa ćemo je ostaviti ovdje
function provjeri_prethodnog(string $fname,string $lname,string $suggestions):bool{
    global $dbc;
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

function returnUrls(int $userId):array{
    $urls=[];
    //urls for non admins
     $urls["logout"]='<a href="logout.php" target="_self">Logout</a>';
     $urls["profile"]='<a href="profile.php" target="_self">User profile</a>'; 
     $urls["delete"]='<a href="terminirajprofil.php" target="_self">Delete profile</a>';
      $urls["updatep"]='<a href="updateprofilne.php" target="_self">Update profile picture</a>'; 
    global $dbc;

   $sql="SELECT u.uloga from uloge u where user_id='$userId'";
   $stmt=mysqli_query($dbc,$sql);
   $query=mysqli_fetch_assoc($stmt);
   //urls for admins
   if($query["uloga"]==="Administrator"){
        $urls["currentFeedbacks"]='<a href="trenutnifeedback.php" target="_self">Current feedbacks</a>';
        $urls["userRoles"]='<a href="dodjeli_uloge.php" target="_self">Assign user roles</a>';    
   }
   return $urls;
}

function logout(){
    $msg="Logged out.";
    session_unset();
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
//function for dynamically create update query 
function createUpdateQuery(array $keyValArray, string $tableName, array $columnValue):string{
  $sql="";
  $sql.="UPDATE ".$tableName." set ";
  $arraySize=count($keyValArray);
  $currentIndex=0;
  foreach ($keyValArray as $key => $value) {
    $currentIndex++;

    $sql.=$key."=";
    if($currentIndex===$arraySize){
         $sql.="'".$value."'";
    }else{
         $sql.="'".$value."',";
    }

  }
  $sql.=" WHERE ";

  foreach ($columnValue as $key => $value) {
     $sql.=$key."=".$value;
  }


  return $sql;
}
function unsetProfileSessions():void{
        //destroy those sessions
    unset($_SESSION["firstName1"]);
    unset($_SESSION["lastName1"]);
    unset($_SESSION["sex1"]);
    unset($_SESSION["dateOfBirth1"]);
    unset($_SESSION["cityOfBirth1"]);
    unset($_SESSION["countryOfBirth1"]);
    unset($_SESSION["email1"]);
    unset($_SESSION["uloga1"]);
}

function unsetImageSessions():void{
      unset($_SESSION["imageId"]);
    unset($_SESSION["imageType"]);
    unset($_SESSION["imageData"]);
}

//function will check if user already have profile picture 
//if user have profile picture redirect user to profile update
//to prevent insert picture because we have updated 
//profilna table email must be unique and not empty
function checkProfilePicture(string $email):bool{
    $exists=true;
    return $exists;
}
//function for printing footer in php page
function printFooter():string{
   $footer= "<footer>
    <p id='datum'></p>
    </footer>";
    return $footer;
}
//function for printing body onmouseover tag
function printBodyOnMouseOver():string{
    $body="<body onMouseOver='prikazi_datum(),dohvati_kalendar3()'>";
    return $body;
}
//function for printing onmouseover and body onload tag
function printBodyOnMouseOverAndOnLoad():string{
     $body="<body onMouseOver='prikazi_datum(),dohvati_kalendar3()', onLoad='slike()'>";
    return $body;
}
//function for printing calendar section
function printCalendar():string{
    $calendar="<section id=\"cal\">
    <h2>Calendar for March 2017</h2>
    <p id='calendar'></p>
    </section>";
    return $calendar;
}
//function for js file includes
function jsIncludes():string{
    $js="
    <script src='socialnet.js'></script>
<script src='calendar.js'></script>
<script src='dropdownmenu.js'></script>
<script src='randomslike.js'></script>";
    return $js;
}


//function for printing rand picture section
function printPictures():string{
    $pictures="<section id='randslike'>
<h2>Random slike</h2>
<p id='s'></p>
</section>";
    return $pictures;
}



//function for printing rand videos section
function printVideos():string{
    $videos="<section id='radnomvideozapisi'>
<h2>Random videozapisi</h2>

</section>";
    return $videos;
}
//function for printing dropdown menu
function dropdownMenu():string{
    $email=(isset($_SESSION["username"]))?$_SESSION["username"]:"";
    $dropdown="";
    $dropdown.="<ul id='f1'>";
    $dropdown.="<li>";
    $dropdown.="<a href='#'";
    $val="m1";
    $dropdown.="onMouseOver=";
    $dropdown.='"openmenu(\'';
    $dropdown.=$val;
    $dropdown.='\')"';

    $dropdown.=" onMouseOut=";
    $dropdown.='"menuclosetime(';
    $dropdown.=')"';
    $dropdown.=">Options</a>";

        
    $dropdown.="<div id='m1'";

       $dropdown.=" onMouseOver=";
    $dropdown.='"menucanceltime(\'';
    $dropdown.=$val;
    $dropdown.='\')"';

    $dropdown.=" onMouseOut=";
    $dropdown.='"menuclosetime(';
    $dropdown.=')"';
    $dropdown.=">";
    $dropdown.="<a href='profilna.php?email=".$email."' target='_self'>Insert profile picture</a>";

    $dropdown.="</div>";

    $dropdown.="</li>";
$dropdown.="</ul><div style='clear:both'></div>";
return $dropdown;
}
//function to check if there is already profile picture in database
function checkIfThereIsAlreadyProfilePictureInDatabase(string $email):bool{
    global $dbc;
  $alreadyExists=false;
  $sql="SELECT count(*) as number FROM profilna p where email='$email'";
  $res=mysqli_query($dbc,$sql);
  $r=mysqli_fetch_assoc($res);
  $alreadyExists=($r["number"]>0)?true:false;
  return $alreadyExists;
}