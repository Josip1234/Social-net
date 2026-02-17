<?php 
namespace App\Controllers;

use App\Helpers\Conversions;
use App\Helpers\Validation;
use App\Models\State;
use Core\Controller;
use Core\Url;
use App\Models\User;
use Core\Auth;

class HomeController extends Controller{
    //this const is default user type
    private const REGULAR="Regular";
    //this function will rerutn index view
    public function index():void{
        $this->view('home/index');
    }
    //return login page
    //if there is any post data process data
    public function login():void{
          //this array will recieve validated value and array of errors
            $auth_array=[];
                //first we need to check number of registered users number of admins
            //get number of registered users
            $num=User::getNumberOfRegisteredUsers();
            $numberOfRegisteredUsers=Conversions::convertToIntValue($num,"userNum");
              //get number of admins
            $numAdmins=User::getNumberOfAdminUsers();
            $numberOfAdminUsers=Conversions::convertToIntValue($numAdmins,"userNum");
               //get number of records in account type
            $numAccTypes=User::getNumberOfAccountTypes();
            $numberOfRecordsUserTypes=Conversions::convertToIntValue($numAccTypes,"userNum");
            
            //get account type data from database
            $accountTypes=User::getRecordsFromAccountTypeTable();
            //convert assoc array to indexed array
            $dataTypeRecords=Conversions::convertToIndexArray($accountTypes);
            //get number of database users
            $nDu=User::getNumberOfDatabaseUser();
            $numberOfDatabaseUserRecords=Conversions::convertToIntValue($nDu,"usNum");
            //get list of database users
            $databaseU=User::getRecordsOfDatabaseUsers();
            //convert a list to regular array
            $databaseUsers=Conversions::convertToIndexArray($databaseU);
            //if user does not exists return view with errors
            $auth_array[]=Auth::requireRegistration($numberOfRegisteredUsers,
            $numberOfAdminUsers,$numberOfRecordsUserTypes,$dataTypeRecords,
            $numberOfDatabaseUserRecords,$databaseUsers);
             $errors='Error.';
                        //if error array exist and it is set add to error string
            if((int)isset($auth_array[0][1]["userNum"][0])===1){
                $errors.=$auth_array[0][1]["userNum"][0];
            }

              if((int)isset($auth_array[0][1]["recordNum"][0])===1){
                $errors.=$auth_array[0][1]["recordNum"][0];
            }

            if((int)isset($auth_array[0][1]["numRegAdm"][0])===1){
                $errors.=$auth_array[0][1]["numRegAdm"][0];
            }

              if((int)isset($auth_array[0][1]["numDatUs"][0])===1){
                $errors.=$auth_array[0][1]["numDatUs"][0];
            }

               if((int)isset($auth_array[0][1]["numRegAdmDat"][0])===1){
                $errors.=$auth_array[0][1]["numRegAdmDat"][0];
            }

                if((int)isset($auth_array[0][1]["unkErr"][0])===1){
                $errors.=$auth_array[0][1]["unkErr"][0];
            }
           
            //to differ user auth we need to return additional parametar to enable again login form
                if($auth_array[0][0]["validated"]===0){
                $this->view('home/login',[
                    'error'=>$errors,
                    'auth'=>0
                ]);
                return;
            }

         if($_SERVER["REQUEST_METHOD"] ==="POST"){
          
            //we need user from database
            $user=User::findByUsername($_POST["username"]);
        
          
       
    
            $errors='Incorrect data.';


            //if user does not exists in database and auth validation has not been passed
            //or user has not been fetched or auth has not been passed
            //return error, 
            if(!$user && $auth_array[0][0]["validated"]===0 || (!$user || $auth_array[0][0]["validated"]===0)){
                $this->view('home/login',[
                    'error'=>$errors,
                    'auth'=>1
                ]);
                return;
            }
            
        }
        $this->view('home/login');
    }
        //function for get and post for registration user
        public function register(){
             //if sessions exists and variables are not empty
             //activate account 
             if(isset($_SESSION["registrationDate"]) && isset($_SESSION["email"]) && isset($_SESSION["userAccountType"])){
                if(!empty($_SESSION["registrationDate"]) && !empty($_SESSION["email"]) && !empty($_SESSION["userAccountType"])){
                    //find user id 
                    $userId=User::getUserId($_SESSION["email"]);
                    //find account type id
                    $accTypeId=User::getAcTypeId($_SESSION["userAccountType"]);
                    //return true if activated account                    
                    $activated=User::activate_account($userId["userId"],$accTypeId["acTypeId"],$_SESSION["registrationDate"]);
                    if($activated===1){
                        echo "Account has been activated.";
                        unset($_SESSION["registrationDate"]);
                        unset($_SESSION["email"]);
                        unset($_SESSION["userAccountType"]);
                    }
                }
             }
            //if data has been posted
            if($_SERVER["REQUEST_METHOD"]==="POST"){
                //perform validation first
                         $validation=Validation::validateForm();
            
              //if validation has been passed register user
            if($validation===true){
                 User::register($_POST);
                 //set registration date email and user account type name in the session for account activation
                 $_SESSION["registrationDate"]=$_POST["registrationDate"];
                 $_SESSION["email"]=$_POST["email"];
                 $_SESSION["userAccountType"]=self::REGULAR;
          
                 $this->view('home/register');
            //in every other case return to registration form with validation errors
            //also return posted data to fill out old values if they are inputted
             }else{
                 $this->view('home/register',[
                    'errors'=>$validation,
                    'data'=>$_POST
                 ]);
            }
            }
       
            $this->view('home/register');
        }
        
    
}