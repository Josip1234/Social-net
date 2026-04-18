<?php 
namespace App\Models;
use App\Helpers\FilesHelper;
use Core\Database;
use Exception;
use mysqli_sql_exception;
use PDOException;

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
     public static function uploadImage(string $url):?string{
        $imageName="";
      
        if(!isset($_FILES["image"]) || $_FILES["image"]["error"] !== UPLOAD_ERR_OK){
          return null;
        }
        $tmpName=$_FILES["image"]["tmp_name"];
       
        $originalName=basename($_FILES["image"]["name"]);
        $extension=pathinfo($originalName,PATHINFO_EXTENSION);
        $allowed=['jpg','jpeg','png','gif','webp','svg'];
        if(!in_array(strtolower($extension),$allowed)){
         return null;
        }
        //session url is the original image which will be used to validate if image is the same
        //i do not know if there is a better way to validate if upload picture is the same 
        //we putted new image name, but since url is extra, this is one kind of a use of url in
        //our database, in future versions it will be removed and better implementation will be 
        //done
        $_SESSION["url"]=$originalName;
        $ur=$_SESSION["url"];
        $getUrlFromDatabase=self::returnUrlFromDatabase($ur);
        if($getUrlFromDatabase["url"]===$ur){
           $imageName="";
           $_SESSION["imageUploadError"]="There is already uploaded picture in database.";
        }else{
               $newName=uniqid("image_").'.'.$extension;
               $destination=$url.'/'.$newName;
               move_uploaded_file($tmpName,$destination);
               $imageName=$newName;
        }
        return $imageName;
     }
     //function which inserts new record into image table
     public static function insertNewImageRecord(array $image,string $imgName,string $url):array{
         $errors=[];
         $db=Database::getInstance();
         $sql="INSERT INTO image (userId,imageName,url,profileMarkImage) values (:userId,:imageName,:url,:profileMarkImage)";
         $stmt=$db->prepare($sql);
         try{
         $stmt->execute([
               ":userId"=>$image["userId"],
               ":imageName"=>$imgName,
               ":url"=>$url,
               ":profileMarkImage"=>$image["profileMarkImage"],
         ]);
         }catch(mysqli_sql_exception $pdo){
            $errors["error"]=$pdo->getMessage();
         }
          return $errors;
         
     }
     //function for update profileMarkImage, set to null
     public static function updateProfileMarkImage(int $userId):array{
        $errors=[];
         $db=Database::getInstance();
         $sql="update image set profileMarkImage=null  where profileMarkImage = :profileMarkImage and userId = :userId";
         $stmt=$db->prepare($sql);
         $profileMarkImage="p";
         try{
         $stmt->execute([
            ':profileMarkImage'=>$profileMarkImage,
            ':userId'=>$userId
         ]);
         }catch(mysqli_sql_exception $pdo){
            $errors["error"]=$pdo->getMessage();
         }
         return $errors;
     }
     //function for update profileMarkImage, set to original value
      public static function updateProfileMarkImageToNewImage(int $imageId,int $userId):array{
         $errors=[];
         $db=Database::getInstance();
         $sql="update image set profileMarkImage=:profileMarkImage  where imageId=:imageId and userId = :userId";
         $stmt=$db->prepare($sql);
         $profileMarkImage="p";
         try{
         $stmt->execute([
            ':profileMarkImage'=>$profileMarkImage,
            ':userId'=>$userId,
            ':imageId'=>$imageId
         ]);
         }catch(mysqli_sql_exception $pdo){
            $errors["error"]=$pdo->getMessage();
         }
         return $errors;
     }
     //function for selecting latest inserted id from user
     public static function getLatestId(int $userId){
      $db=Database::getInstance();
      $sql="SELECT max(imageId) as max from image where userId=:userId";
      $stmt=$db->prepare($sql);
      $stmt->execute([
         ':userId'=>$userId,
      ]);
      return $stmt->fetch();
     }
     //function to return url on upload image if there is already original file in database
     //do not upload file on server!
     public static function returnUrlFromDatabase(string $originalUrl){
       $db=Database::getInstance();
       $sql="SELECT url from image where url=:originalUrl";
       $stmt=$db->prepare($sql);
       $stmt->execute([
          ':originalUrl'=>$originalUrl
       ]);
       return $stmt->fetch();
     }
   
}