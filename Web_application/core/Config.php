<?php 
namespace Core;
class Config{
    //this function returns app env if there is no key defined it returns default
    //default is regular user
    public static function get(string $key,$default=null){
        return $_ENV[$key] ?? $default;
    }
    //this function will set env variables depending user
    public function chooseEnv(){

    }
}