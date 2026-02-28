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
}