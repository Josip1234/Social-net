<?php
class File_Directory
{
    private $directory_name;
    private $available;

    public function __construct($directory_name)
    {
        $this->directory_name = $directory_name;
    }
    public function getDirectoryName()
    {
        return $this->directory_name;
    }

    public function setDirectoryName($directory_name)
    {
        $this->directory_name = $directory_name;
    }
    
    //function will scan files and return results as string
    public function scan_files_in_directory(){
        $res="";
        
// Open a directory, and read its contents
if (is_dir($this->getDirectoryName())){
  if ($dh = opendir($this->getDirectoryName())){
    while (($file = readdir($dh)) !== false){
        //skip points
        if($file=="."){
            continue;
        } else if($file==".."){
            continue;
        }else if($file=="newfile.txt"){
            continue;
        }
        else{
            $res.=$this->getDirectoryName().$file.",";
        }
    }
    closedir($dh);
  }
}
        return $res;
    }

    //need to get a list of directories from database 
    //if file has same value as in directory in our database 
    //skip it do not add it to the array
}
