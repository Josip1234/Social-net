<?php
namespace App\Controllers;

use App\Models\State;
use Core\Controller;
use App\Models\City;

class AddressController extends Controller{
    public function updateAddress(){
        $states=State::selectAllStatesFromDatabase();
        if(isset($_COOKIE["selected"]) && ($_COOKIE["selected"]!="-")){
            $cities=City::getCityRecordById($_COOKIE["selected"]);
        }
        else{
            $cities=[];
        }
        $this->view("address/update_form",[
            "states"=>$states,
            "cities"=>$cities,
        ]);
    }
}