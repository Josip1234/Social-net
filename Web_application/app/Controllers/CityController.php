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
           $state=State::selectAllStatesFromDatabase();
        $this->view("address/city",[
            "states"=>$state
        ]);
        }elseif($_SERVER["REQUEST_METHOD"]==="POST"){
            if(isset($_POST["dbCity"])){
               
                City::insertNewCity($_POST);
                   $_SESSION["msg"]="Successfully inserted new city.";
                header("Location: index.php?page=city");
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