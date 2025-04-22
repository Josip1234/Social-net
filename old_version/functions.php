<?php

function provjeri_prethodnog($fname,$lname,$suggestions){
    include("dbconn.php");
	$sql1="SELECT suggestion FROM kvaliteta WHERE id = id-1";
	mysqli_query($dbc,$sql1);
	if($suggestions==$sql1){
		$sql2="DELETE * FROM kvaliteta WHERE id=id";
		mysqli_query($dbc,$sql2);
		return 1;
	};
}
function provjeri_dali_postoji_u_bazi($username,$password){
	include("dbconn.php");
	$query="SELECT id FROM registration WHERE email='$username' AND pass='$pass'";
	$q=mysqli_query($dbc,$query);
	if($res=mysqli_fetch_array($q)){
		if($res==$username && $res==$pass){
			$_SESSION['username']=$username;
			$_SESSION['pass']=$pass;
			$_SESSION['loggedin']=1;
			session_start();
			mysqli_close($dbc);
		}
	}else{
		session_destroy();
		$_SESSION['loggedin']=0;
		die('User does not exists in database. You can use registration form to register, after that you will be able to log in into our social network.');
		mysqli_close($dbc);
	}
}
function dodjeli_sesiju($username){
	
}

//za poboljšanje funkcije napraviti će se nova s kojom će se odabirati pozicija brojeva, dali prvo ide slovo ili broj
//i maksimalno generiranje slov i brojki koje korisnik zadaje za početak je ovo zadovoljavajuće.
//funkcija koja generira i vraća serijski broj
function generiraj_random_serijski($veličina_serijskog,$maksimalni_generirani_broj){
$serial="";


for ($j=0; $j <$veličina_serijskog; $j++) { 
	$lt=generiraj_random_slovo();
	$nm=generiraj_random_broj(0,$maksimalni_generirani_broj);
	$serial=$serial.$lt.$nm;
}


return $serial;
}

//generiraj random slovo kao seed se koristi veličina engleske abecede
function generiraj_random_slovo(){
	$slova=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$size=count($slova);
	$slovo=$slova[rand(0,$size-1)];
	return $slovo;
}
//funckija za generiranje random broja minimum i maksimum raspon je potrebno definirati
function generiraj_random_broj($min,$max){
	$broj=rand($min,$max);
	return $broj;
}
//funkcija sprema serijski broj u bazu vraća true ako je spremljeno false ako nije
function spremi_serijski_u_bazu($serial_num){
	
	$exists=false;
	$used=0;
	$saved=false;
    $exists=provjeri_dali_postoji_serijski_u_bazi($serial_num);

	if($exists==1){
         echo "Serijski već postoji u bazi.";
	}else if($exists==0){
	
		include("dbconn.php");
		
		$sql="INSERT INTO serial_numbers(serial,used) VALUES ('$serial_num','$used')";
		
		$query=mysqli_query($dbc,$sql);
		//ovdje se serijski izgubi
		//echo $serial_num;

		if($query){
		
			$saved=true;
			mysqli_close($dbc);
		}else{
			
			$saved=false;
			mysqli_close($dbc);
		}
		
	}

	return $saved;
}
//funkcija provjerava dali postoji serijski u bazi ako postoji vrati true ako ne vrati false
function provjeri_dali_postoji_serijski_u_bazi($serial){
	include("dbconn.php");
	$exists=0;
	$sql="SELECT serial FROM serial_numbers WHERE serial='$serial'";
	$ex_query=mysqli_query($dbc,$sql);
	$numrows=$ex_query->num_rows;
	
	if($numrows==0){
		mysqli_close($dbc);
		$exists=0;
		
	}else{
	
		$exists=1;
		mysqli_close($dbc);
	}
return $exists;
}

  //dodana tablica serial number koja će sadržavati random serijske brojeve iz koje će se vaditi podaci za serial image 
   //serial image u tablici table history je vezan za serial_numbers
   //za svaki klik na stranici prvo generiraj random number
   //zatim provjeri dali postoji u bazi 
   //ako ne postoji dodaj u bazu 
   //napiši u funkciju tako
   //serijski broj mora sadržavati slova i brojeve
/*
$serijski=generiraj_random_serijski(rand(0,30),rand(0,255));
spremi_serijski_u_bazu($serijski);
*/

function provjeri_postoji_li_već_slika_profila_u_bazi($email){
	$postoji=true;
	include "dbconn.php";
	$sql="SELECT email FROM profilna WHERE email='$email'";
	$query=mysqli_query($dbc,$sql);
	$numrows=$query->num_rows;
	if($numrows==1){
		$postoji=true;
		mysqli_close($dbc);
	}else if($numrows==0){
		$postoji=false;
		mysqli_close($dbc);
	}
	return $postoji;
}


//ova funkcija će skenirati direktorije za slike i vratiti listu slika.
function dohvati_listu_slika_iz_direktorija(){
	//Get the current working directory:
	//echo getcwd();
	$current_directory=getcwd();
	$direktorij_za_skeniranje="\\slike\\";
	//sortira se prema rastućem rasporedu
	//$list=scandir($current_directory.$direktorij_za_skeniranje);
	//print_r($list);
	$direktorij=$current_directory.$direktorij_za_skeniranje;
	$relativni_put="/Social-net/old_version/slike/";
	$filename="js/random.js";
	// Open a directory, and read its contents
	$index=0;
if (is_dir($direktorij)){
	if ($dh = opendir($direktorij)){
	  while (($file = readdir($dh)) !== false){
		//preskoči točke
		if($index==0){
			$index++;
			continue;
			
		}else if($index==1){
			$index++;
			continue;
		}else{
//echo "filename:" . $file . "<br>";
echo  "<img src='".$relativni_put.$file . "'></img><br>";
write_to_js_file($filename,$file);
		}
		
	  }
	  closedir($dh);
	}
  }

}

//zapiši javascript file
//parametar je direktorij relativni put
//PHP Append Text
//You can append data to a file by using the "a" mode. The "a" mode appends text to the end of the file, while the "w" mode overrides (and erases) the old content of the file.
//In the example below we open our existing file "newfile.txt", and append some text to it:
function write_to_js_file($filename,$file){
	$myfile = fopen($filename, "a") or die("Unable to open file!");
	$txt = "$file\n";
	fwrite($myfile, $txt);
	fclose($myfile);
}

 //Before using the fopen function, one should check with is_dir first if it exists, if not create it using the mkdir function −
 //$filename = '/path/to /file.txt';
 //$dirname = dirname($filename);
//if (!is_dir($dirname)) {
//   mkdir($dirname, 0755, true);
//}
  
 
?>