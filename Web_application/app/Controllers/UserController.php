<?php 
namespace App\Controllers;

use App\Helpers\FilesHelper;
use App\Helpers\Validation;
use App\Models\AccountType;
use App\Models\Image;
use App\Models\ProfileDetail;
use App\Models\ProfileLogger;
use Core\Controller;
use Core\Auth;
use App\Models\User;



class UserController extends Controller{
        //activate helpers for checking and creating user image folders if they are not existing
        public function index(){
            Auth::requireLogin();
         
            $userWithoutAddress=User::selectNumAddress($_SESSION["user"]["id"]);
            $userWithoutImage=User::selectNumImage($_SESSION["user"]["id"]);
        
            if($userWithoutAddress>0){
                 //$profil=User::profileData($_SESSION['user']['id']);
                 $profil="";
            }else{
                 $profil=User::profileData($_SESSION['user']['id']);
                 if($profil==false){
                    $profil=[];
                    $userImage=[];
                  
                 }else{
                    $userImage=Image::selectUserImage($_SESSION["user"]["id"],'p');    
                 }
                 
               
            }
             
            if($userWithoutImage===0 || $userWithoutImage==false){
                 $userImage="";
            }else{
                  $userImage=Image::selectUserImage($_SESSION["user"]["id"],'p');
                  
                 
            }
              
            
             $this->view('users/profile',[
                'profil'=>$profil,
                'profileImage'=>$userImage,
                'userImage'=>$userWithoutImage,
                'usrAddr'=>$userWithoutAddress,
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
                   header('Location: index.php');
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
                //if user does not have profile image
                if(isset($_GET["option"])){
                        //if option is insert then user can insert profile image in database
                        //before that, view with a form will be shown
                        if($_GET["option"]==="insert"){
                                  $this->view('users/profile_img_update');
                        }
                }else{
                 $_SESSION["fullUrl"]=FilesHelper::displayFullUrl();
                if(isset($_SESSION["imageUploadError"])){
                        unset($_SESSION["imageUploadError"]);
                }
                $currentDirectory=isset($_GET["id"])?$_GET["id"]:0;
                $directory=FilesHelper::returnCurrentUrl($currentDirectory);
                $profileMarkImage=isset($_GET["profileMarkImage"])?$_GET["profileMarkImage"]:'';
                $userImage=Image::selectUserImage($_SESSION["user"]["id"],$profileMarkImage);
                $this->view('users/profile_img_update',[
                   'directory'=>$directory,
                   'profileImage'=>$userImage,
                ]);;
                };
        }
        //current profile will be last inserted by user
        public function updateImg(){
               
                $errors=[];
                $imgName=Image::uploadImage(FilesHelper::returnCurrentUrl($_SESSION["user"]["id"]));
                $image=$_POST;
                $url=isset($_SESSION["url"])?$_SESSION["url"]:"";
                if(isset($_SESSION["imageUploadError"])){

                        $url=$_SESSION["fullUrl"];
                        unset($_SESSION["fullUrl"]);
                        //return to image update
                       header('Location: '. $url);
                }else{
                   $errors=Image::insertNewImageRecord($image,$imgName,$url);
                   $id=Image::getLatestId($_SESSION["user"]["id"]);
                   $errors=Image::updateProfileMarkImage($_SESSION["user"]["id"]);
                   $errors=Image::updateProfileMarkImageToNewImage($id["max"],$_SESSION["user"]["id"]);
                      if(empty($errors)){
                         unset($_SESSION["url"]);
                         header('Location:index.php?page=users/profile');
                       }
                }
                
             
               
        }
        public function editAccountType(){
                Auth::requireLogin();
                Auth::requireAdmin(); 
                $accountTypeList=AccountType::getAllRecordsFromAccountTypeTable();
                if(isset($_GET["id"])){
                           $profileDetailsId=ProfileDetail::getProfileDetailId($_GET["id"]);
                             $currentRole=ProfileDetail::getAccountTypeId($_GET["id"]);
                }
              
                $this->view('users/update_account_type',
                [
                        'account_type'=>$accountTypeList,
                        'id'=>$profileDetailsId,
                        'role'=>$currentRole
                ]);
        }
        public function insertNewImage(){
                
                $errors=[];
                
                $imageName=Image::uploadImage(FilesHelper::returnCurrentUrl($_SESSION["user"]["id"]));
              
                $image=$_POST;
               
                 $url=isset($_SESSION["url"])?$_SESSION["url"]:"";
                    if(isset($_SESSION["imageUploadError"])){

                        $url=$_SESSION["fullUrl"];
                        unset($_SESSION["fullUrl"]);
                        //return to image update
                       header('Location: '. $url);
                }else{
                   $errors=Image::insertNewImageRecord($image,$imageName,$url);
                   $id=Image::getLatestId($_SESSION["user"]["id"]);

                      if(empty($errors)){
                         unset($_SESSION["url"]);
                         header('Location:index.php?page=users/profile');
                       }
                }
        }
        public function profile_log_index(){
                //this is a fix to prevent empty list and pagination available for next previous 
                if(!isset($_GET["pag"])) header('Location: index.php?page=profile_log&pag=1');
                $limit=5;
                $page=isset($_GET["pag"])?$_GET["pag"]:0;
                $totalRow=ProfileLogger::countRowsForProfileLog();
                  $logList=ProfileLogger::getProfileLogWithPagination($limit,$page);
                $totalPages=ceil(($totalRow/$limit));

                $paginationStart=max(1, $page - floor($limit/2));
                $paginationEnd=$paginationStart+$limit-1;

                if($paginationEnd > $totalPages){
                    $paginationEnd = $totalPages;
                    $paginationStart=max(1,$paginationEnd-$limit+1);
                }
                


              
                $this->view("admin/user_log",
                ["users"=>$logList,
                "total_pages"=>$totalPages,
                "page"=>$page,
                "pagStart"=>$paginationStart,
                "pagEnd"=>$paginationEnd
                ]);
               
        }
}