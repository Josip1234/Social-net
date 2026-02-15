<?php 
namespace App\Helpers;
class Validation{
    //validate form depending on post method
    //return array or bool value true
    public static function validateForm():array|bool{
        //intitialize error array
        $errors=[];
        //if request method is post
        if($_SERVER["REQUEST_METHOD"]==="POST"){
                //if post variable regValidation is set and different than null
                //and if value of hidden field equals validate
                //that means registration form has been sent
                if(isset($_POST["regValidation"]) && $_POST["regValidation"]==="validate"){
                        $fname=self::clean_input($_POST["fname"]);
                        $lname=self::clean_input($_POST["lname"]);
                        $email=self::clean_input($_POST["email"]);
                        $sex=$_POST["sex"];
                        $dbirth=$_POST["dbirth"];
                        //if address exists recive post variable from address
                        //and if input value is yes
                        if(isset($_POST["includeAddress"]) && $_POST["includeAddress"]==="yes"){
                                $city=self::clean_input($_POST["city"]);
                                $state=self::clean_input($_POST["state"]);
                                $address=self::clean_input($_POST["address"]);

                                if(empty($city)){
                                    $errors["ct"]="City is empty.";
                                }
                                if(empty($state)){
                                    $errors["st"]="State is empty.";
                                }
                                if(empty($address)){
                                    $errors["ad"]="Address is empty.";
                                }
                                
                        }
                        $password=self::clean_input($_POST["hp"]);

                        if(empty($fname)){
                            $errors["fn"]="First name is empty.";
                        }
                        if(empty($lname)){
                            $errors["ln"]="Last name is empty.";
                        }
                        if(empty($email)){
                            $errors["em"]="Email is empty.";
                        }
                         if(empty($sex)){
                            $errors["sx"]="Sex has not been chosen.";
                        }
                        if(empty($dbirth)){
                            $errors["db"]="Date of birth has not been chosen.";
                        }
                        if(empty($password)){
                            $errors["ps"]="Password is empty.";
                        }
                    
                        
                       
                }
        }
        //if array size of errors is not 0 return error array 
        //otherwise return false
        if(count($errors)>0){
            return $errors;
        }else{
                return true;
        }
    
    }
//clean input form data 
//this counts for 1 string
private static function clean_input($data) {
    //strip whitespace from beggining and end of the string
  $data = trim($data);
  //unquote quoted string
  $data = stripslashes($data);
  //converts special characters to html entities, prevents sal injection
  $data = htmlspecialchars($data);
  return $data;
}



}