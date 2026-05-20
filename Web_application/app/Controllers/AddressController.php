<?php
namespace App\Controllers;

use App\Helpers\Validation;
use App\Models\Address;
use App\Models\State;
use Core\Controller;
use App\Models\City;

class AddressController extends Controller{
    public function updateAddress(){
        $states=State::selectAllStatesFromDatabase();
        $userId=$_SESSION['user']['id'];
        $address=Address::getAddressFromCurrentUser($userId);
        if(!empty($address)){
                 $_COOKIE["selected"]=$address["stateId"];
        }
   
       
        if(isset($_COOKIE["selected"]) && ($_COOKIE["selected"]!="-")){
            $cities=City::getCityRecordById($_COOKIE["selected"]);
        }
        else{
            
            $cities=[];
        }
   
        //if there is address in state
        //get list of cities
        $foundAddressInState=false;
        foreach ($states as $value) {
            if($value["stateId"]==$address["stateId"]){
                $foundAddressInState=true;
                break;
            }
        }
        
        if($foundAddressInState===1){
            $cities=City::getCityRecordById($address["stateId"]);
            $_COOKIE["selected"]=$address["stateId"];
        }

        $this->view("address/update_form",[
            "states"=>$states,
            "cities"=>$cities,
            "address"=>$address
        ]);
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
    
}