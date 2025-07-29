<?php
class File_Directory
{
    const TABLE_NAME="file_directory_for_scan";
    const COLUMN_NAME_DIRECTORY="name";
    const ROOT_DIRECTORY="/Social-net/";

    protected $directory_name;
    //this $available variable is extra maybe we will need to delete this variable class
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
    //two objects needed database connection object
    public function scan_files_in_directory($database_connection){
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
        }else if($this->check_if_directory($file,$database_connection)==1){
            continue;
        }
        else{
            $file_parts=pathinfo($file);
            if(isset($file_parts["extension"])){
            switch ($file_parts["extension"]) {
                case 'jpg':
                    $res.=$this->getDirectoryName().$file.",";
                    break;
                case 'png':
                     $res.=$this->getDirectoryName().$file.",";
                    break;
                case 'jpeg':
                     $res.=$this->getDirectoryName().$file.",";
                     break;
                case 'gif':
                     $res.=$this->getDirectoryName().$file.",";
                     break;
                case NULL:
                    break;
            }
        }
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
    //file is file name and it is always string
    //database connection is database connection from where we will get a list of data
    public function check_if_directory($file,$database_connection){
        $list_of_directories=array();
       $is_directory=0;
       //retireve list od directories in database
    $list_of_directories=$database_connection->select_from_database(File_Directory::COLUMN_NAME_DIRECTORY,File_Directory::TABLE_NAME);
       foreach ($list_of_directories as $value) {
         if($file==$value){
            $is_directory=1;
         }
       }
       return $is_directory;
    }
}
