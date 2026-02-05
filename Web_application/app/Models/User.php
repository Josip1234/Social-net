<?php

namespace App\Models;

use Core\Database;

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
            ':hp' => $data[':hp']
        ]);
    }
    //function for activating account, 
    //two parameters user id to add user id in profile details table and acctype id
    //it is id from account type role of the user should be already known.
    //also need registration date as additional field
    //registration date should be passed with hidden field
    //account will be activated right away after registration
    public static function activate_account(int $userId, int $accTypeId, string $registration):bool{
        $db=Database::getInstance();
        $sql="INSERT INTO profiledetails (userId,acTypeId,registrationDate,accountStatus)
        values (:uid,:atid,:rdate,:astatus)";
        $stmt=$db->prepare($sql);
        $stmt->execute([
            ':uid'=>$userId,
            ':atid'=>$accTypeId,
            ':rdate'=>$registration,
            ':astatus'=>'Active'
        ]);
        return $stmt->rowCount()===1;

    }
    //this function will return array of user data if user exists
    //? optional return data array
    public static function findByUsername(string $username):?array{
        $db=Database::getInstance();
        $sql="SELECT p.userId,
        concat('p.firstName',' ','p.lastName') as username,
        p.email FROM profile p WHERE p.email = :email";
        $stmt=$db->prepare($sql);
        $stmt->execute([':email'=>$username]);
        $user=$stmt->fetch();
        return $user ?:null;
    }
}
