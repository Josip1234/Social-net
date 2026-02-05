<?php 
namespace App\Controllers;
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