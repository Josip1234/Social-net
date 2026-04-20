<?php
namespace App\Models;
use Core\Database;
class ProfileDetail{
        //function for update account type in profiledetails table
    public static function update_account(int $accTypeId, int $userId){
      $db=Database::getInstance();
      $sql = "UPDATE profiledetails set acTypeId=:acTypeId, pdUpdateDate=:pdUpdateDate where userId=:userId";
      $stmt=$db->prepare($sql);
      return $stmt->execute([
          ':acTypeId'=>$accTypeId,
          ':userId'=>$userId,
          ':pdUpdateDate'=>\Carbon\Carbon::now()
      ]);
    }

          //return registrationDate from profile details from database
      public static function selectRegistrationDate(int $userId):string{
        $regDate="";
        $db=Database::getInstance();
        $sql = "SELECT pd.registrationDate FROM profiledetails pd where pd.userId=:userId";
        $stmt=$db->prepare($sql);
        $stmt->execute([
          ':userId'=>$userId
        ]);
        $regDate=$stmt->fetchColumn();
        return \Carbon\Carbon::parse($regDate)->format("Y-m-d");
      }

            //function to return account type id using user id
      public static function getAccountTypeId(int $userId):int{
        $db=Database::getInstance();
        $sql="SELECT pd.acTypeId FROM profiledetails pd where userId=:userId";
        $stmt=$db->prepare($sql);
        $stmt->execute([
          ':userId'=>$userId
        ]);
        return $stmt->fetchColumn();
      }


          //function for update account status
    public static function updateAccountStatus(array $profileDet){
      $db=Database::getInstance();
      $sql="UPDATE profiledetails set pdUpdateDate=:pdUpdateDate, accountStatus=:accountStatus where userId=:userId";
      $stmt=$db->prepare($sql);
      return $stmt->execute([
          ':pdUpdateDate'=>date("Y-m-d H:i:s"),
          ':accountStatus'=>$profileDet['accountStatus'],
          ':userId'=>$profileDet['userId']
      ]);
    }
    //function for getting profile detail id 
    public static function getProfileDetailId(int $userId):int{
      $db=Database::getInstance();
      $sql="select proDetId from profiledetails where userId=:userId";
      $stmt=$db->prepare($sql);
      $stmt->execute([
          ':userId'=>$userId
      ]);
      return $stmt->fetchColumn();
    }
}