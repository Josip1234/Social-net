<?php

namespace App\Models;

use Core\Database;
use Core\Auth;

class User
{
    //function for inserting new user to database
    //address id is nullable, it can be fullable later on 
    //when user update his profile account
    public static function register(array $data): void
    {
        $db = Database::getInstance();
        $sql = "INSERT INTO profile(firstName,lastName,email,sex,dateOfBirth,addressId,hashPassword)
values (:fname,:lname,:email,:sex,:dbirth,:adid,:hp)";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':fname' => $data['fname'],
            ':lname' => $data['lname'],
            ':email' => $data['email'],
            ':sex' => $data['sex'],
            ':dbirth' => $data['dbirth'],
            ':adid' => $data['adid'],
            ':hp' => password_hash($data['hp'],PASSWORD_DEFAULT)
        ]);
    }
    //function for activating account, 
    //two parameters user id to add user id in profile details table and acctype id
    //it is id from account type role of the user should be already known.
    //also need registration date as additional field
    //registration date
    //account will be activated right away after registration
    public static function activate_account(int $userId, int $accTypeId, string $registration_date):bool{
        $db=Database::getInstance();
        $sql="INSERT INTO profiledetails (userId,acTypeId,registrationDate,accountStatus)
        values (:uid,:atid,:rdate,:astatus)";
        $stmt=$db->prepare($sql);
        $stmt->execute([
            ':uid'=>$userId,
            ':atid'=>$accTypeId,
            ':rdate'=>$registration_date,
            ':astatus'=>'Active'
        ]);
        return $stmt->rowCount()===1;

    }

    //this function will return array of user data if user exists
    //? optional return data array
    public static function findByUsername(string $username):?array{
        $db=Database::getInstance();
        $sql="SELECT p.userId,
        concat(p.firstName,' ',p.lastName) as username,
        p.email,p.hashPassword as hp FROM profile p WHERE p.email = :email";
        $stmt=$db->prepare($sql);
        $stmt->execute([':email'=>$username]);
        $user=$stmt->fetch();
        return $user ?:null;
    }
      //function to get number of registered users
      public static function getNumberOfRegisteredUsers():array{
        $db=Database::getInstance();
        $sql="select count(p.userId) as userNum from profile p";
        return $db->query($sql)->fetchAll();
      }
      //function to get number of admin users
      public static function getNumberOfAdminUsers():array{
        $db=Database::getInstance();
        $sql="select count(p.userId) as userNum from profile p inner join profiledetails pd on p.userId=pd.userId
            inner join accounttype `at` on pd.acTypeId=`at`.acTypeId";
        return $db->query($sql)->fetchAll();
      }

 
      //function for getting a number of database user
      public static function getNumberOfDatabaseUser():array{
        $db=Database::getInstance();
        $sql="SELECT count(dbu.userId) as usNum FROM databaseuser dbu";
        return $db->query($sql)->fetchAll();
      }
      //function for getting a list of database users
      public static function getRecordsOfDatabaseUsers():array{
        $db=Database::getInstance();
        $sql="SELECT dbu.userName as usNa FROM databaseuser dbu";
        return $db->query($sql)->fetchAll();
      }
      //function for getting userId from database depending on user email
      public static function getUserId(string $email):int{
         $userId=0;
         $db=Database::getInstance();
         $sql="SELECT p.userId from profile p where p.email=:email";
         $stmt=$db->prepare($sql);
         $stmt->execute([
            ':email'=>$email
         ]);
         $userId=$stmt->fetchColumn();
         return $userId;
      }

      //select max id from database
      public static function selectMaxId():int{
        $maxId=0;
        $db=Database::getInstance();
        $sql="SELECT MAX(p.userId) as Max FROM profile p";
        $maxId=$db->query($sql)->fetchColumn();
        return $maxId;
      }



      //function to return username by id
      public static function getUserNameById(int $userId):string{
        $db=Database::getInstance();
        $sql="SELECT p.email as Email FROM profile p where userId=:userId";
        $stmt=$db->prepare($sql);
        $stmt->execute([
          ':userId'=>$userId
        ]);
        return $stmt->fetchColumn();
      }

      //function to return data from user
      public static function profileData(int $userId):array|bool{
         $db=Database::getInstance();
         $sql="select p.userId,p.firstName,p.lastName,p.email,p.sex,p.dateOfBirth,i.imageName,i.url,i.profileMarkImage,pd.acTypeId,aty.acTypeName,pd.accountStatus,pd.registrationDate
              ,ad.street,cit.postNumber,cit.name as CitName,st.name as StName from profile p right join image i on p.userId=i.userId
              right join profiledetails pd on p.userId=pd.userId 
              right join address ad on p.addressId=ad.addressId
              right join city cit on ad.postNumber=cit.postNumber
              right join state st on cit.stateId=st.stateId
              right join accounttype aty on 
              pd.acTypeId = aty.acTypeId
              where p.userId=:userId";
          $stmt=$db->prepare($sql);
          $stmt->execute([":userId"=>$userId]);
               //if there is failure for fetching data return empty field otherwise fetch data
          return $stmt->fetch();
      }
      //function for updating basic user information
      public static function updateProfileTable(array $profile){
            $db=Database::getInstance();
            $sql="UPDATE profile set firstName=:fname, lastName=:lname, email=:email, sex=:sex, dateOfBirth=:dbirth
            where userId=:userId";
            $stmt=$db->prepare($sql);
            return $stmt->execute([
                ':fname'=>$profile['fname'],
                ':lname'=>$profile['lname'],
                ':email'=>$profile['email'],
                ':sex'=>$profile['sex'],
                ':dbirth'=>$profile['dbirth'],
                ':userId'=>$profile['userId']
            ]);
      }
      //function for updating basic image data
      public static function updateImageDate(array $basicImageData){
        $db=Database::getInstance();
        $sql="UPDATE image set imageName=:imageName, url=:url where userId=:userId and imageId=:imageId";
        $stmt=$db->prepare($sql);
        return $stmt->execute([
            ':imageName'=>$basicImageData['imageName'],
            ':url'=>$basicImageData['url'],
            ':userId'=>$basicImageData['userId'],
            ':imageId'=>$basicImageData['imageId']
        ]);
      }
    //function for update account type
    public static function updateAccountType(array $profileDet){
      $db=Database::getInstance();
      $sql="UPDATE profiledetails set acTypeId=:acTypeId where userId=:userId";
      $stmt=$db->prepare($sql);
      return $stmt->execute([
          ':acTypeId'=>$profileDet['acTypeId'],
          ':userId'=>$profileDet['userId']
      ]);
    }

    //function to get all user id-s from database
    public static function getAllUserIds():array{
        $db=Database::getInstance();
        $sql="SELECT p.userId FROM profile p order by p.userId asc";
        return $db->query($sql)->fetchAll();
    }
    //function to select if user have address or does not have address
    public static function selectNumAddress(int $userId):int{
      $db=Database::getInstance();
      $sql="SELECT count(p.userId) as uNumber FROM profile p where p.addressId is null and p.userId=:userId";
      $stmt=$db->prepare($sql);
      $stmt->execute([
        ':userId'=>$userId
      ]);
      $res=$stmt->fetchColumn();
      return $res;
    }
    //function to select if user have image or does not have image
    public static function selectNumImage(int $userId):int{
      $db=Database::getInstance();
      $sql="SELECT count(p.userId) as uNumber FROM profile p inner join image i where p.userId=i.userId and 
      p.userId=:userId";
      $stmt=$db->prepare($sql);
      $stmt->execute([
        ':userId'=>$userId
      ]);
      $res=$stmt->fetchColumn();
      return $res;
    }
    //function to update user address in table profile
    public static function updateUserAddress(int $addressId, int $userId):void{
      $db=Database::getInstance();
      $sql="UPDATE profile set addressId=:addressId where userId=:userId";
      $stmt=$db->prepare($sql);
      $stmt->execute([
          ':addressId'=>$addressId,
          ':userId'=>$userId
      ]);
    }
    //this query will be used to retrieve profile log data will retrieve all first 
    //later we will add limit and offset for pagination
    /*
    
    SELECT pf.plId as id,concat(p.firstName,' ',p.lastName) as username,pf.message,
pf.additionDate,pf.updateDate,p.dateOfBirth, at.acTypeName, round(datediff(now(),p.dateOfBirth)/
(SELECT DAYOFYEAR(
    LAST_DAY(DATE_ADD(NOW(), INTERVAL 12-MONTH(NOW()) MONTH))
)
),0) as Age FROM profile_logger pf join profile p on pf.userId=p.userId
join profiledetails pd on p.userId=pd.userId join accounttype at on pd.acTypeId=at.acTypeId;
    


    
    
    */
}
