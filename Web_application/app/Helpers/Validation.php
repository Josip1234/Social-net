<?php 
namespace App\Helpers;

use Carbon\Carbon;

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
                        //if first name is empty add error to array
                        //or if length of the string is equal to 0
                        if(empty($fname) || strlen($fname)===0){
                            $errors["fn"]="First name is empty.";
                        }
                        //if name is numeric or has numbers in string value add error to array
                        if(is_numeric($fname) || (self::hasNumbersInString($fname))){
                            $errors["fnn"]="First name cannot have numbers.";
                        }
                        if(empty($lname) || strlen($lname)===0){
                            $errors["ln"]="Last name is empty.";
                        }
                          if(is_numeric($lname) || (self::hasNumbersInString($lname))){
                            $errors["lnn"]="Last name cannot have numbers.";
                        }
                        if(empty($email)){
                            $errors["em"]="Email is empty.";
                        }
                        if((int)self::validateEmail($email)===0){
                            $errors["ism"]="Invalid email.";
                        }
                         if(empty($sex)){
                            $errors["sx"]="Sex has not been chosen.";
                        }
                        if($sex!=="m" || $sex!=="f"){
                            $errors["sxv"]="Value can be only m for male, f for female. Invalid input.";
                        }
                        if(empty($dbirth)){
                            $errors["db"]="Date of birth has not been chosen.";
                        }
                        //if date of birth is equal to today call error
                        //if difference between date of birth and today date is equal to zero 
                        //call an error
                        $date1=Carbon::parse($dbirth);
                        $date2=Carbon::now();
                        $dateDiffInDays=$date1->diffInDays($date2);
                        //if date difference is less that zero it is future date
                        if($dateDiffInDays===0 || $dateDiffInDays<0){
                            $errors["dtb"]="Date of birth cannot be today or future date.";
                        }
                        if(empty($password)){
                            $errors["ps"]="Password is empty.";
                        }
                        if(strlen($password)<8){
                            $errors["pl"]="Password have less than 8 characters. Please, add more characters.";
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
//function which will return true if string contains number
private static function hasNumbersInString(string $value):bool{
    $containsNumber=false;
    for($i=0;$i<strlen($value);$i++){
        if(is_numeric($value[$i])){
            $containsNumber=true;
            break;
        }
    }
    return $containsNumber;
}
//function for email validation
//it will be simple validation, if string contains @ only
//this validation will be updated
private static function validateEmail(string $value):bool{
    $isEmail=true;
    //email must contain @ and must have at least 1 .
    $monkeyCharCount=0;
    for($i=0;$i<strlen($value);$i++){
            if($value[$i]==='@'){
                $monkeyCharCount++;
            }
    }
       if($monkeyCharCount>1){
                $isEmail=false;
                
            }else if($monkeyCharCount==0){
                $isEmail=false;
            }
  
    return $isEmail;
}

}