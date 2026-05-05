<?php
namespace App\Controllers;

use App\Helpers\Validation;
use App\Models\State;
use Core\Controller;
use Core\Auth;

class StateController extends Controller{
    public function stateIndex(){
        Auth::requireLogin();
        $this->view("address/new_state");
    }
    public function insertNewState(){
        Auth::requireLogin();
        if($_SERVER["REQUEST_METHOD"]==="POST"){
            $errors=[];
            $errors=Validation::validateStateInput();

            if(!empty($errors)){
                $this->view("address/new_state",[
                    "state"=>$_POST,
                    "errors"=>$errors
                ]);
            }
             State::insertNewStateIntoDatabase($_POST);
                $_SESSION["msg"]="Successfully inserted new state.";
                header("Location: index.php?page=address/new_state");
        }
    }
}