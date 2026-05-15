<?php
namespace App\Controllers;

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
}