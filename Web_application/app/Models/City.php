<?php 
namespace App\Models;

use Core\Database;

class City{
    //function for searching city name 
    //need postal number first 
    //if postal number already exists, 
    //return count 1 
    //otherwise return count 2
   // SELECT count(c.postNumber) as data FROM city c where c.name='Zagreb';

   //function for selecting city depending on chosen state
   public static function getCityRecord(string $state):array{
    $db=Database::getInstance();
    $sql="SELECT c.postNumber,c.name FROM city c inner join state s on c.stateId=s.stateId where s.name=:state";
    $stmt=$db->prepare($sql);
    $stmt->execute([
        ":state"=>$state,
    ]);
    return $stmt->fetchAll();
   }
}