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
        $image=new Image("","","","");
        $what_data=array();
        $what_data[]=Scanned_data::COLUMN_NAME;
        $imgs=$database_connection_object->print_all_data_from_database(Scanned_data::TABLE_NAME,$what_data);
        return $imgs;

    }
//SELECT * FROM `scanned_data` WHERE `url` LIKE '%.txt'; select everything which has .txt in it 
//SELECT * FROM `scanned_data` WHERE `url` NOT LIKE '%.jpeg%' OR NOT LIKE '%.jpg%';
//we can use this query SELECT * FROM `scanned_data` WHERE `url` NOT LIKE '%.jpeg%' AND `url` NOT LIKE '%.jpg%' AND `url` NOT LIKE '%.png%' AND `url` NOT LIKE '%.gif%';
//will select values which dont contains image extensions
//make function fix database 
//will retrive id's from records which contains txt 
//then we will execute delete operations
public function maintainDatabase($database_connection){
$values_to_select=array("id","url");
$fetch_data_which_does_not_have_image_extension=array();
$fetch_data_which_does_not_have_image_extension=$database_connection->select_from_database_all_except_image_extensions(Scanned_data::TABLE_NAME,$values_to_select);
//delete values by id
$tn=Scanned_data::TABLE_NAME;
foreach ($fetch_data_which_does_not_have_image_extension as $value) {
    if(gettype($value)=="integer"){
        $query="DELETE FROM $tn WHERE id=?";
        $statement=$database_connection->getDbconn()->prepare($query);
        $statement->bind_param("i",$value);
        $statement->execute();
    }else{
       continue;
    }
}


}


}

?>