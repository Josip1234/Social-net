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
            //get number of admins
            $numAdmins=User::getNumberOfAdminUsers();
            //get number of records in account type
            $numAccTypes=User::getNumberOfAccountTypes();
            //get account type data from database
            $accountTypes=User::getRecordsFromAccountTypeTable();
            //convert assoc array to indexed array
            $at=Conversions::convertToIndexArray($accountTypes);
            //get number of database users
            
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