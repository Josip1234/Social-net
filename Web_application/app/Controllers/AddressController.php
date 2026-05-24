<?php
namespace App\Controllers;

use App\Helpers\Validation;
use App\Models\Address;
use App\Models\State;
use Core\Controller;
use App\Models\City;

class AddressController extends Controller{
    public function updateAddress(){
            $userId=$_SESSION['user']['id'];
      $address=Address::getAddressFromCurrentUser($userId);

        if(isset($_GET["selected"])){
            if((int)$_GET["selected"]===1){
                $state=(int)($_POST["state"]);
            
                $cities=City::getCityRecordById($state);
                  

                  $this->view("address/update_form",[
                     'cities'=>$cities,
                    'address'=>$address
        ]);
            }
            
        }elseif(isset($_GET["city"])){
            if((int)$_GET["city"]===1){
                 $add=Address::getAddresses($_POST["city"]);
                
                $this->view("address/update_form",[
                    'add'=>$add,
                    'address'=>$address
        ]);
            }
        }elseif(isset($_GET["add"])){
            if((int)$_GET["add"]===1){
                Address::updateAddress($_POST,$_SESSION["user"]["id"]);
                $_SESSION["msg"]="Successfully updated address";
                header("Location: index.php?page=address/update");
            }
        }
        
        else{

   

          $states=State::selectAllStatesFromDatabase();
    
      


        $this->view("address/update_form",[
            'states'=>$states,
            'address'=>$address
        ]);
        }
    }
    public function insertNewAddress(){
         $states=State::selectAllStatesFromDatabase();
          if(isset($_COOKIE["selected"]) && ($_COOKIE["selected"]!="-")){
            $cities=City::getCityRecordById($_COOKIE["selected"]);
        }
        else{
            
            $cities=[];
        }
        $this->view("address/new_address",[
            "states"=>$states,
            "cities"=>$cities
        ]);
    }
    //prilikom inserta adrese potrebno je napraviti trigger i proceduru 
    //koja će automatski ažurirati profil staviti najnoviji id od adrese
    public function storeAddress(){
        $errors=[];
        $errors=Validation::validateAddressFormInput();
        if($errors===true){
                Address::insertNewAddress($_POST);
                $_SESSION['msg']="Successfully inserted new address.";
                header("Location: index.php?page=users/profile");
        }else{

          $states=State::selectAllStatesFromDatabase();
          if(isset($_COOKIE["selected"]) && ($_COOKIE["selected"]!="-")){
            $cities=City::getCityRecordById($_COOKIE["selected"]);
        }
        else{
            
            $cities=[];
        }


           $this->view("address/new_address",[
                        'errors'=>$errors,
                        $_POST, 
                           "states"=>$states,
                         "cities"=>$cities
                     ]);
        }
    }
    public function editAddress(){
        
    }
    
}