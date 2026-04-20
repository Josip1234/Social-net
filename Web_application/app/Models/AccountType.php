<?php 
namespace App\Models;
use Core\Database;
class AccountType{
          //function to get number of user type records in table account type
      public static function getNumberOfAccountTypes():array{
        $db=Database::getInstance();
        $sql="select count(act.acTypeId) as userNum from accounttype act";
        return $db->query($sql)->fetchAll();
      }
           //function to get fields of user types in account type table
      public static function getRecordsFromAccountTypeTable():array{
        $db=Database::getInstance();
        $sql="select act.acTypeName as dataTypeRec from accounttype act";
        return $db->query($sql)->fetchAll();
      } 
            //function for selecting account type id depending of account type name
          public static function getAcTypeId(string $accountTypeName):int{
         $userId=0;
         $db=Database::getInstance();
         $sql="SELECT at.acTypeId FROM accounttype at where at.acTypeName=:acTypeName";
         $stmt=$db->prepare($sql);
         $stmt->execute([
            ':acTypeName'=>$accountTypeName
         ]);
         $userId=$stmt->fetchColumn();
         return $userId;
      }
            //function to get all of data from user types in account type table
      public static function getAllRecordsFromAccountTypeTable():array{
        $db=Database::getInstance();
        $sql="select * from accounttype act";
        return $db->query($sql)->fetchAll();
      }
}