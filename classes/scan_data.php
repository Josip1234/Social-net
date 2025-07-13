<?php
include("images.php");
class Scanned_data
{
    const TABLE_NAME="scanned_data";
    const COLUMN_NAME="url";
    
    private $url;
    public function __construct($url)
    {
        $this->url = $url;
    }
    public function getUrl()
    {
        return $this->url;
    }
    public function setUrl($url)
    {
        $this->url = $url;
    }
    //insert scanned urls to tabase into the table
    public function insert_scanned_data_into_database($database_connection_object,$dataset){
        $tn=Scanned_data::TABLE_NAME;
        $query="INSERT INTO $tn (url) VALUES (?)";
        foreach ($dataset as $value) {
            //check if url already exists in database
            $exists=$database_connection_object->check_for_unique($tn,"COUNT(*)",Scanned_data::COLUMN_NAME,$value);
            //insert into database if value does not exists
            //if data exists skip current url continue to check others
            if($exists==0){
               $statement=$database_connection_object->getDbconn()->prepare($query);
               $statement->bind_param("s",$value);
               $statement->execute();
               
            }else if($exists==1){
                 continue;
            }else if(empty($value)||($value=="")){
                echo "There is empty value. This value will not be inserted into our database.";
            }
        }
    }
    public function return_list_of_images_from_database($database_connection_object){
        $imgs=array();
        $image=new Image("","","");
        $what_data=array();
        $what_data[]=Scanned_data::COLUMN_NAME;
        $imgs=$database_connection_object->print_all_data_from_database(Scanned_data::TABLE_NAME,$what_data);
        return $imgs;

    }

}
