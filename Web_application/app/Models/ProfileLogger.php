<?php 
namespace App\Models;
use Core\Database;
use Carbon\Carbon;
class ProfileLogger{
    //this function will insert data when user has logged in
    public static function log(int $userId,string $message){
        $db=Database::getInstance();
        $sql="INSERT INTO profile_logger (userId, message, additionDate) VALUES (:userId,:message,:additionDate)";
        $stmt=$db->prepare($sql);
        $stmt->execute([
            ':userId'=>$userId,
            ':message'=>$message,
            ':additionDate'=>Carbon::now()
        ]);
    }
          //function for selecting last inserted id for profile logger
      public static function getLastIdFromProfileLogger(int $userId):int{
        $db=Database::getInstance();
        $sql="SELECT max(pl.plId) FROM profile_logger pl where pl.userId=:userId";
        $stmt=$db->prepare($sql);
        $stmt->execute([
              ':userId'=>$userId
        ]);
        return $stmt->fetchColumn();
      }
      //function for update profile logger to log user logout
      public static function updateProfileLogger(int $profileLoggerId):bool{
        $db=Database::getInstance();
        $sql = "UPDATE profile_logger set updateDate=:updateDate where plId=:profileLoggerId";
      $stmt=$db->prepare($sql);
      return $stmt->execute([
          ':updateDate'=>\Carbon\Carbon::now(),
          ':profileLoggerId'=>$profileLoggerId,
      ]);

      }
}