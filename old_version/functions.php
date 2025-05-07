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
	$function_start="function slike(){";
	$function_end="}";
    $rand_func="var b=Math.floor(Math.random()*slik.length);";
	$return_func="document.getElementById('s').innerHTML='<img src='+slik[b]+'></img>'";"'";
	//Get the current working directory:
	//echo getcwd();
	$current_directory=getcwd();
	$direktorij_za_skeniranje="\\slike\\";
	//sortira se prema rastućem rasporedu
	//$list=scandir($current_directory.$direktorij_za_skeniranje);
	//print_r($list);
	$direktorij=$current_directory.$direktorij_za_skeniranje;
	$relativni_put="/Social-net/old_version/slike/"; //sprema se kao dio url-a u slikama
	$filename="js/random.js"; //mjesto gdje će se epremati txt linkovi prema slikama
	// Open a directory, and read its contents
	$index=0;
	write_to_js_file($filename,$function_start,"w");
	write_to_js_file($filename,"var slik=[","a");
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
//echo  "<img src='".$relativni_put.$file . "'></img><br>";
//ako se naleti slučajno na file koji se zove newfile.txt kojeg smo napravili prilikom testiranja neka samo preskoči.
if($file=="newfile.txt"){
	continue;
}else{
	write_to_js_file($filename,'"'.$relativni_put.$file.'",',"a"); //spoji relativni put i datoteku koja se skenirala pa prosljedi funkciji write to js file
}

		}
		
	  }
	  write_to_js_file($filename,"];","a");
	  write_to_js_file($filename,$rand_func,"a");
	  write_to_js_file($filename,$return_func,"a");
	  write_to_js_file($filename,";","a");
	  write_to_js_file($filename,$function_end,"a");
	
	  closedir($dh);
	}
  }

}

//zapiši javascript file
//parametar je direktorij relativni put
//PHP Append Text
//You can append data to a file by using the "a" mode. The "a" mode appends text to the end of the file, while the "w" mode overrides (and erases) the old content of the file.
//In the example below we open our existing file "newfile.txt", and append some text to it:
function write_to_js_file($filename,$file,$mode){
	$myfile = fopen($filename, $mode) or die("Unable to open file!");
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
  
function getSerialNumberFromDatabase(){
	include("dbconn.php");
	//QUERY KOJI SELEKTIRA PRVI SERIJSKI KOJI NIJE KORIŠTEN
	$sql_query="SELECT serial FROM serial_numbers WHERE used = '0' LIMIT 1;";
	$query=mysqli_query($dbc,$sql_query);
	$res=$query->fetch_column();
    return $res;
} 

//sljedeća funkcija će spremati profile picture history uz korisnikov pristanak
function saveProfileHistory($imageSerial,$imageType,$imageData,$email){
	include("dbconn.php");
	//echo '<img src="data:'.$imageType.';base64,'.base64_encode($imageData).'" />';
	//$imgData=base64_encode($imageData);
	//echo '<img src="data:'.$imageType.';base64,'.$imgData.'" />';
	$saved=false;
	//$dat=base64_decode($imageData);
	$sql = "INSERT INTO profile_image_history(image_serial,imageId,imageType,imageData,email) VALUES('$imageSerial','0','{$imageType['mime']}', '{$imageData}','$email')";
mysqli_query($dbc,$sql);
mysqli_close($dbc);
update_serial($imageSerial);
$saved=true;
	return $saved;
}
//funkcija za ispis profile image history-a
function print_image_profile_history($email){
	include("dbconn.php");
	$sql="SELECT imageType,imageData FROM profile_image_history WHERE email='$email'";
$res=mysqli_query($dbc,$sql);
while($row=mysqli_fetch_array($res)){
    
    echo '<img src="data:'.$row['imageType'].';base64,'.base64_encode($row['imageData']).'"width="30%" height="30%" />';
}
mysqli_close($dbc);
}

//ažuriraj serijski broj da je korišten prilikom spremanja povijesti slike profila
function update_serial($serial){
	include("dbconn.php");
	$sql_query="UPDATE serial_numbers SET used='1' WHERE serial='$serial'";
	$exe_q=mysqli_query($dbc,$sql_query);
	if($exe_q){
		echo "Update successfull.";
	}
}

?>