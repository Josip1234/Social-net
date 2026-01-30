<?php 
namespace Core;
class Auth{

//this function returns session admin if user is admin
    public static function isAdmin():bool{
        return isset($_SESSION['user']) &&
        $_SESSION['user']['type']==='Admin';
    }
    //this function calls is admin function 
    //if user is not admin user cannot continue until his role is admin
    //limits user role for only admin
    public static function requireAdmin():void{
        if(!self::isAdmin()){
            die('Access forbidden. Admin user role is needed.');
        }
    }
    //this is function for checking if user is logged in
    //if user is not logged in, it redirects user to login page
    //exit Terminates execution of the script
    public static function requireLogin():void{
        if(!isset($_SESSION['user'])){
            header("Location: index.php?page=login");
            exit;
        }
    }
    //this function returns userid if exists
   // ?? -It returns its first operand if it exists and is not NULL; otherwise it returns its second operand.
    //So it's actually just isset() in a handy operator.
    //Those two are equivalent1:
    //$foo = $bar ?? 'something';
    //$foo = isset($bar) ? $bar : 'something';
    // function returns user id if exists
    public static function userId():int{
        return (int)($_SESSION['user']['id']??0);
    }
    //this function is checking if user is registered
    public static function isRegistered():bool{
        return isset($_SESSION['user']);
    }
}