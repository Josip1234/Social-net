<?php
class File_Directory
{
    private $directory_name;

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
        }else{
            $res.=$this->getDirectoryName().$file.",";
        }
    }
    closedir($dh);
  }
}
        return $res;
    }
}
