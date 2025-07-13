<?php
class Scanned_data
{
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
        $query="INSERT INTO scanned_data (url) VALUES (?)";
        foreach ($dataset as $value) {
            //check if url already exists in database
            $exists=$database_connection_object->check_for_unique("scanned_data","COUNT(*)","url",$value);
            //insert into database if value does not exists
            //if data exists skip current url continue to check others
            if($exists==0){
               $statement=$database_connection_object->getDbconn()->prepare($query);
               $statement->bind_param("s",$value);
               $statement->execute();
               echo "New records inserted successfuly";
            }else if($exists==1){
                 continue;
            }
        }
    }
}
/*prepare and bind
$stmt = $conn->prepare("INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $firstname, $lastname, $email);

// set parameters and execute
$firstname = "John";
$lastname = "Doe";
$email = "john@example.com";
$stmt->execute();

$firstname = "Mary";
$lastname = "Moe";
$email = "mary@example.com";
$stmt->execute();

$firstname = "Julie";
$lastname = "Dooley";
$email = "julie@example.com";
$stmt->execute();

echo "New records created successfully";

$stmt->close();
$conn->close();
*/