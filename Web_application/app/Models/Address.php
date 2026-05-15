<?php 
namespace App\Models;

use Core\Database;

class Address{
    //function to get adresses depending on city post number
    public function getAddresses(int $postNumber):array{
        $db=Database::getInstance();
        $sql="SELECT a.street,a.postNumber FROM address a where postNumber=:postNumber";
        $stmt=$db->prepare($sql);
        $stmt->execute([
            ":postNumber"=>$postNumber,
        ]);
        return $stmt->fetchAll();
    }
    //function to get address from current logged in user
    //we need address id street name post number of city and state id
    public static function getAddressFromCurrentUser(int $userId):array{
        
        $db=Database::getInstance();
        $sql="SELECT p.addressId,a.street,a.postNumber,s.stateId FROM profile p inner join address a 
            on p.addressId=a.addressId 
            inner join city c on a.postNumber=c.postNumber
            inner join state s on c.stateId=s.stateId
            where p.userId=:userId";
        $stmt=$db->prepare($sql);
        $stmt->execute([
            ':userId'=>$userId
        ]);
        return $stmt->fetch();
    }
}