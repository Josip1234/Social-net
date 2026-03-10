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
    //function for selecting all the states from database
    public static function selectAllStatesFromDatabase():array{
        $db=Database::getInstance();
        return $db->query("SELECT s.stateId,s.name FROM state s order by s.stateId asc")->fetchAll();
    }
    //function for selecting a state by id 
    public static function selectStateNameById(int $stateId):string{
        $selected="";
        $db=Database::getInstance();
        $sql="SELECT s.name FROM state s where stateId=:stateId";
        $stmt=$db->prepare($sql);
        $stmt->execute([
            ":stateId"=>$stateId
        ]);
        $selected=$stmt->fetchColumn();
        return $selected;
    }
}