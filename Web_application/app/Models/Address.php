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
}