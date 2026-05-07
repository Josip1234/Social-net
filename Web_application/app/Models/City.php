<?php 
namespace App\Models;

use Core\Database;
use Core\Auth;
use App\Helpers\Validation;

class City{
    //function for searching city name 
    //need postal number first 
    //if postal number already exists, 
    //return count 1 
    //otherwise return count 2
   // SELECT count(c.postNumber) as data FROM city c where c.name='Zagreb';

   //function for list of cities depending on state name
   public static function getCityRecord(string $state):array{
    $db=Database::getInstance();
    $sql="SELECT c.postNumber,c.name FROM city c inner join state s on c.stateId=s.stateId where s.name=:state";
    $stmt=$db->prepare($sql);
    $stmt->execute([
        ":state"=>$state,
    ]);
    return $stmt->fetchAll();
   }
   //function for list of the cities depending on state id
      public static function getCityRecordById(int $stateId):array{
    $db=Database::getInstance();
    $sql="SELECT c.postNumber,c.name FROM city c inner join state s on c.stateId=s.stateId where s.stateId=:stateId";
    $stmt=$db->prepare($sql);
    $stmt->execute([
        ":stateId"=>$stateId,
    ]);
    return $stmt->fetchAll();
   }
   //function for inserting new city in database
    public static function insertNewCity(array $data){
            
             $db = Database::getInstance();
        $sql = "INSERT INTO city(postNumber,name,stateId)
values (:postNumber,:name,:stateId)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':postNumber'=>$data["postNumber"],
            ':name'=>$data["name"],
            ':stateId'=>$data["stateId"]
        ]);
    }
    
        public static function checkInsertedCity(string $postNumber):bool{
        $db=Database::getInstance();
        $isInserted=false;
        $sql="SELECT count(c.postNumber) as number from city c where c.postNumber=:postNumber";
        $stmt=$db->prepare($sql);
        $stmt->execute([':postNumber'=>$postNumber]);
        $isInserted=($stmt->fetchColumn()>0)?$isInserted=true:$isInserted=false;
        return $isInserted;
    } 
}