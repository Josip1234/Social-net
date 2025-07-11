<?php
class Randomjs
{
    const FUNCTION_START = "function slike(){";
    const ARRAY_START = "var slik=[";
    //image urls
    private $images;
    const CLOSE_ARRAY = "];";
    const RANDOM_FUNCTION_COUNT = "var b=Math.floor(Math.random()*slik.length);";
    const IMAGE_FETCHING = "document.getElementById('s').innerHTML='<img src='+slik[b]+' ></img>';";
    const FUNCTION_END="}";

    public function __construct($images)
    {
        $this->images = $images;
    }
    public function getImages()
    {
        return $this->images;
    }
    public function setImages($images)
    {
        $this->images = $images;
    }


    //ova funkcija će skenirati direktorije za slike i vratiti listu slika.
function dohvati_listu_slika_iz_direktorija(){
	$function_start=Randomjs::FUNCTION_START;
	$function_end=Randomjs::FUNCTION_END;
    $rand_func=Randomjs::RANDOM_FUNCTION_COUNT;
	$return_func=Randomjs::IMAGE_FETCHING;
	//Get the current working directory:
	//echo getcwd();
	$current_directory=getcwd();
    //za prilagodbu direktorija trebasamo primijeniti put u \\slike\\nešto\\ i treba promijeniti relativni put /slike/nešto/
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
	save_pictures_to_random_js($direktorij,$relativni_put,$filename,false);
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

}//kao provremeno riješenje za fix napisati ćemo ime podirektorija i privjerava se ako je to taj string
else if($file=="something"){
      //echo $file;//file name su something (to bi trebao biti ime direktorija)
	  $directory=$file;
	  //koristimo prijašnju varijablu za relativni put
	  //filename varijablu prijašnju deklariranu gdje ćemo spremiti podatke.  
	  //spoji trenutni direktorij koji se skenira sa imenom poddirektorija (something)
	  $subdirectory_to_scan=$direktorij.$file;
	  //echo $subdirectory_to_scan;
	  //tu trebamo funkciju postaviti kao i prethodnu kod će se ponavljati za sada neka se ponavlja.
	  //funkcija će pisati također nakon prekskanja točki u file datoteke.
	  //relativni put spajamo u funkciji
	  save_pictures_to_random_js($subdirectory_to_scan,$relativni_put.$file,$filename,true);
	/*  $preskoci_tocke=0;
	  if (is_dir($subdirectory_to_scan)){
          
		  if ($dh2 = opendir($subdirectory_to_scan)){
			while (($file2 = readdir($dh2)) !== false){
                  //echo $subdirectory_to_scan."\\".$file2;
				  $drugi_relativni_put=$relativni_put."/".$directory."/".$file2;
                 echo $drugi_relativni_put;
				 write_to_js_file($filename,'"'.$drugi_relativni_put.'",',"a");
			}
		  }
		    closedir($dh2);
	  }*/

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



    //spremati će se urlovi slika u obliku polja u random.js
//subdirectory označava dali je poddirektorij ili ne bitno je za skeniranje
function save_pictures_to_random_js($directory_for_reading,$relative_path,$name_of_file_for_save,$is_subdirectory){
	//echo $relative_path;
	$skip_full_stop_index=0;

	if($is_subdirectory==true){
		  if (is_dir($directory_for_reading)){
          
		  if ($dh2 = opendir($directory_for_reading)){
			while (($file2 = readdir($dh2)) !== false){
                 	//preskoči točke
		if($skip_full_stop_index==0){
			$skip_full_stop_index++;
			continue;
			
		}else if($skip_full_stop_index==1){
			$skip_full_stop_index++;
			continue;
		}else{
				  $drugi_relativni_put=$relative_path."/".$file2;
                 //echo $drugi_relativni_put;
				 write_to_js_file($name_of_file_for_save,'"'.$drugi_relativni_put.'",',"a");
			}
		}
		  }
		    closedir($dh2);
	  }
	}
	
}
}
