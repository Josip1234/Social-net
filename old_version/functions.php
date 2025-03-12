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


function generiraj_random_serijski($veličina_serijskog_broja,$maksimalni_generirani_broj,$koliko_slova_generirati,$format_serijskog){
$serial="";
$slova=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$size=count($slova);

for ($j=0; $j <$veličina_serijskog_broja ; $j++) { 
	for ($i=0; $i <$size ; $i++) { 
		//echo $slova[$i]."<br>";
		echo " ".$slova[rand(0,$size-1)];
		
	}
}



//sve dok ne dođeš do kraja od veličine serijsog broja generiraj random brojeve i slova i dodaj sve to u varijablu serial i
//vrati povratnu vrijednost

return $serial;
}

  //dodana tablica serial number koja će sadržavati random serijske brojeve iz koje će se vaditi podaci za serial image 
   //serial image u tablici table history je vezan za serial_numbers
   //za svaki klik na stranici prvo generiraj random number
   //zatim provjeri dali postoji u bazi 
   //ako ne postoji dodaj u bazu 
   //napiši u funkciju tako
   //serijski broj mora sadržavati slova i brojeve

$serijski=generiraj_random_serijski(2,1500,5,"Slovo broj");
echo $serijski;
?>