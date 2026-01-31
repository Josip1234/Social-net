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

     //if there are no register users return registration form
     //or there is no admin users
     //or there are no registered users and there is no admin users
      //return registration form
     //if there is less than 2 data in user type table stop executing script and display message
     //if there is no user Regular and Social display message
     //then check database users 
     //if number of database records are less than two stop executing script and display message
     //if there is no regular and social_admin in databaseusers table stop executing script and display message
     //anything else stop executing script and display message
      public static function requireRegistration(int $numberOfRegisteredUsers, int $numberOfAdminUsers, int $numberOfRecordsUserTypes, array $dataTypeRecords
      ,int $numberOfDatabaseUserRecords,array $databaseUsers):void{
        if(($numberOfRegisteredUsers===0 || $numberOfAdminUsers<1) || ($numberOfRegisteredUsers===0 && $numberOfAdminUsers<1)){
            header("Location: index.php?page=registration");
            exit;
        }elseif ($numberOfRecordsUserTypes<2) {
             die('There must be at least two records at user type table. Please add missing data.');
        }elseif ($numberOfRecordsUserTypes>=2) {
           if((int)in_array("Regular",$dataTypeRecords)===0 || (int)in_array("Admin",$dataTypeRecords)===0){
            die('There must be at least 1 regular and 1 admin user in table. Please, add some admin and regular user.');
           }
        }elseif ($numberOfDatabaseUserRecords<2) {
            die('There must be at least two database users in database user table.');
        }elseif ($numberOfDatabaseUserRecords>=2) {
               if((int)in_array("regular",$databaseUsers)===0 || (int)in_array("social_admin",$databaseUsers)===0){
            die('There must be at least 1 user regular and 1 user social_admin in databaseuser table.');
           }
        }else{
            die('Unknown error');
        }
    }

}