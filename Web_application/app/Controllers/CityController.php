<?php
namespace App\Controllers;

use App\Models\City;
use App\Models\State;
use Core\Controller;
use Core\Auth;
use App\Helpers\Validation;

class CityController extends Controller{
    public function city(){
        Auth::requireLogin();
        
        if($_SERVER["REQUEST_METHOD"]==="GET"){
             $stateId=isset($_POST["state"])?$_POST["state"]:0;
           $state=State::selectAllStatesFromDatabase();
        $this->view("address/city",[
            "states"=>$state
        ]);
        }elseif($_SERVER["REQUEST_METHOD"]==="POST"){ 
    
            
            if(isset($_POST["dbCity"])){ 
                $errors=Validation::validateCityFormInput();
                if(empty($errors)){
                    City::insertNewCity($_POST);
                }else{
                     var_dump($errors);
                }

            }else{
            $state=State::selectAllStatesFromDatabase();
            
            $stateId=isset($_POST["state"])?$_POST["state"]:0;
            
                $cities=City::getCityRecordById($stateId);
                $this->view("address/city",[
                "cities"=>$cities,
                "stateId"=>$stateId
            ]);
            }
            
        }
    }
}