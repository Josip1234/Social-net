<?php 
namespace App\Models;
use Core\Database;
class State{
    //function which will get number of records 
    //if there is any state under input name
    //already in database.
    public static function checkInsertedState(string $state):bool{
        $db=Database::getInstance();
        $isInserted=false;
        $sql="SELECT count(s.stateId) as number from state s where s.name=:state";
        $stmt=$db->prepare($sql);
        $stmt->execute([':state'=>$state]);
        $isInserted=($stmt->fetchColumn()>0)?$isInserted=true:$isInserted=false;
        return $isInserted;
    } 
}