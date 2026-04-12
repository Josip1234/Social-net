<?php 
namespace App\Helpers;



//this is a helper class for file manipulation

class FilesHelper{
    private const IMAGE_DIRECTORY=__DIR__.'../../../public/assets/images/';
    //this function will make user directory for images 
    private static function makeDir($userId){
        $url=self::IMAGE_DIRECTORY.$userId;
        if(is_dir($url) || file_exists($url)){
            $errors["de"]="Directory already exists. Please, choose another directory.";
        }else{
             mkdir($url);
        }
       
    }
    //this function will create folders for all registered users in database if they do not have folder for images
    public static function createFoldersForRegisteredUsers(array $data){
       
       foreach($data as $value){
        foreach ($value as $id) {
            //make directory for each user if they do not have image folder
            self::makeDir($id);
        }
       }
    }
    //this function will return current directory of profile image folders
    public static function returnCurrentUrl(int $userId):string{
            $url=self::IMAGE_DIRECTORY.$userId;
           
            return $url;
    }
}

