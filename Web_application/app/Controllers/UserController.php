<?php 
namespace App\Controllers;

use App\Helpers\FilesHelper;
use App\Helpers\Validation;
use Core\Controller;
use Core\Auth;
use App\Models\User;

class UserController extends Controller{
        //activate helpers for checking and creating user image folders if they are not existing
        public function index(){
            Auth::requireLogin();
            $profil=User::profileData($_SESSION['user']['id']);
     
             $this->view('users/profile',[
                'profil'=>$profil
             ]);
        }
        public function edit(){
                Auth::requireLogin();
                $profil=User::profileData($_GET["id"]);
                $this->view('users/update',[
                        'profil'=>$profil
                ]);
        }
        public function update(){
              Auth::requireLogin();
              $validation=Validation::validateForm();
              if($validation===true){
                User::updateProfileTable($_POST);          
                $_SESSION['update']="Successfully updated profile.";
                   $profil=User::profileData($_SESSION['user']['id']);
                $this->view('users/profile',
                ['profil'=>$profil]);
              }else{
                $profil=User::profileData($_SESSION['user']['id']);
                  $this->view('users/update',[
                    'errors'=>$validation,
                    'profil'=>$profil,
                    'data'=>$_POST,
                 ]);
              }
             
        }
        public function updateProfileImage(){
                $currentDirectory=isset($_GET["id"])?$_GET["id"]:0;
                FilesHelper::returnCurrentUrl($currentDirectory);
                $this->view('users/profile_img_update',[
                   'directory'=>$currentDirectory
                ]);;
        }
}