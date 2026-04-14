<?php 
namespace App\Models;
use App\Helpers\FilesHelper;
use Core\Database;

class Image{
     //function for selecting user image from database
     public static function selectUserImage(int $userId, string $profileMarkImage):array{
        $db=Database::getInstance();
        $sql="SELECT i.imageId,i.imageName as alt, i.url, i.profileMarkImage FROM image i where i.userId=:userId and i.profileMarkImage=:profileMarkImage";
        $stmt=$db->prepare($sql);
        $stmt->execute([
            ':userId'=>$userId,
            ':profileMarkImage'=>$profileMarkImage
        ]);
        return $stmt->fetch();
     }
     //function for handle image upload
     public static function uploadImage(string $url,mixed $values):string{
        $imageName="";
        return $imageName;
     }
}