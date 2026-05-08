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
        $state=State::selectAllStatesFromDatabase();
        if($_SERVER["REQUEST_METHOD"]==="GET"){
           
        $this->view("address/city",[
            "states"=>$state
        ]);
        }elseif($_SERVER["REQUEST_METHOD"]==="POST"){
            if(isset($_POST["dbCity"])){
               
                City::insertNewCity($_POST);
                   $_SESSION["msg"]="Successfully inserted new city.";
            
                 $this->view("address/city",[
                    "states"=>$state
            ]);
            }
            $stateId=isset($_POST["state"])?$_POST["state"]:0;
            $validated=Validation::validateCityFormInput();
            if((int)$validated===1){
                $cities=City::getCityRecordById($stateId);
                $this->view("address/city",[
                "cities"=>$cities,
                "stateId"=>$stateId
            ]);
            }else{
                 header("Location: index.php?page=city");
                 
            }
            
        }
    }
}