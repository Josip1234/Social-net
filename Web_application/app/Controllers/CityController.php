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
                       //need state id to get list of cities
                    $stateId=$_SESSION["stateId"];
                     //get list of cities by state id
                    $cities=City::getCityRecordById($stateId);
                    //need addCity post variable to get form for inserting data
                    $_POST["addCity"]=1;
                
                    
                  $_SESSION["msg"]="Successfully inserted new city.";
                      //unset state id session no longer needed
                  unset($_SESSION["stateId"]);
                     $this->view("address/city",[
                        'errors'=>$errors,
                        'cities'=>$cities,
                        $_POST["addCity"]
                     ]);
                }else{
                    //need state id to get list of cities
                    $stateId=$_SESSION["stateId"];
                     //get list of cities by state id
                    $cities=City::getCityRecordById($stateId);
                    //need addCity post variable to get form for inserting data
                    $_POST["addCity"]=1;
    
                    //need to put all posted data with wrong errors also. in future updates.
                     $this->view("address/city",[
                        'errors'=>$errors,
                        'cities'=>$cities,
                        $_POST["addCity"]
                     ]);
                }

            }else{
            $state=State::selectAllStatesFromDatabase();
            
            $stateId=isset($_POST["state"])?$_POST["state"]:0;
               //remember state id when state has been selected 
               //needed to get list of cities when returning to form 
               //where state is already selected.
               $_SESSION["stateId"]=$stateId;
                $cities=City::getCityRecordById($stateId);
                $this->view("address/city",[
                "cities"=>$cities,
                "stateId"=>$stateId
            ]);
            }
            
        }
    }
}