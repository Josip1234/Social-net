<?php 
namespace App\Helpers;
class CookieSessionHelpers{
    //function for delete cookies
    public static function deleteAllCookies():void{
        setcookie("selected","",1);
    }
}