<?php 
namespace App\Controllers;
use Core\Controller;
use Core\Auth;
use App\Models\User;

class UserController extends Controller{
  
        public function index(){
            Auth::requireLogin();
            $profil=User::profileData($_SESSION['user']['id']);
             $this->view('users/profile',[
                'profil'=>$profil
             ]);
        }
}