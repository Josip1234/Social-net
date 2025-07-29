<?php

class File extends File_Directory
{
    private $file_name;

    public function __construct($directory_name, $file_name)
    {
        $this->directory_name = $directory_name;
        $this->file_name = $file_name;
    }

    public function getFileName()
    {
        return $this->file_name;
    }

    public function setFileName($file_name)
    {
        $this->file_name = $file_name;
    }

    //argument can be anything, string or array
    public function create_new_files_if_exists($argument){
        $directoryName=$this->getDirectoryName();
        //first create directory if does not exists
        $file_path = $directoryName;
        if (!file_exists($file_path)) {
         mkdir($file_path, 0777, true);
        }
        //now create new file in directory name
       foreach ($argument as $value) {
         fopen($this->getDirectoryName()."/".$value, 'w') or die("Can't create file");
       }
              
 }
         }

