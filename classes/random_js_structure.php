<?php
class Randomjs
{
    const FUNCTION_START = "function slike(){";
    const ARRAY_START = "var slik=[";
    //image urls
	//we can use this variable to pass array
    private $images;
    const CLOSE_ARRAY = "];";
    const RANDOM_FUNCTION_COUNT = "var b=Math.floor(Math.random()*slik.length);";
    const IMAGE_FETCHING = "document.getElementById('s').innerHTML=slik[b];";
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

//this function is saving javascript function with a filled array field from database
//function concatinate string from values of array, then just owerwrite current js random file 
	public function save_images_to_random_js($root_url,$directory_for_js){
		  $save_to_file=$directory_for_js;
		  $values="";
		  $values.=Randomjs::FUNCTION_START;
		  $values.=Randomjs::ARRAY_START;
		  //for each images in array save to random js
		  $index=1;
		  foreach ($this->getImages() as $value) {
			if($index==sizeof($this->getImages())){
				$values.="\"".$value."\"";
				$values.="";
			}else{
            $values.="\"".$value."\"";
			 $values.=",";
			}
			$index++; 
		  }
		  $values.=Randomjs::CLOSE_ARRAY;
		  $values.=Randomjs::RANDOM_FUNCTION_COUNT;
		  $values.=Randomjs::IMAGE_FETCHING;
		  $values.=Randomjs::FUNCTION_END;

		  $file = fopen($save_to_file, "w") or die("Unable to open file!");
$txt = $values;
fwrite($file, $txt);
fclose($file);

	}

}
