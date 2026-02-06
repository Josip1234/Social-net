<?php 
namespace App\Controllers;

use App\Helpers\Conversions;
use Core\Controller;
use Core\Url;
use App\Models\User;

class HomeController extends Controller{
    //this function will rerutn index view
    public function index():void{
        $this->view('home/index');
    }
    //return login page
    //if there is any post data process data
    public function login():void{
         if($_SERVER["REQUEST_METHOD"]==="POST"){
            //we need user from database
            $user=User::findByUsername($_POST["username"]);
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
            if(!$user){
                $this->view('home/login',[
                    'error'=>'Neispravni podaci.'
                ]);
                return;
            }
            
        }
        $this->view('home/login');
    }

    
}