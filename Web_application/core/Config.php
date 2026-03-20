<?php

namespace Core;

class Config
{
    //this function returns app env if there is no key defined it returns default
    //default is regular user
    public static function get(string $key, $default = '')
    {
        return $_ENV[$key] ?? $default;
    }
    //this function will set env variables depending on registered user and what type user is
    //if app env has not been set set regular user automaticly 
    // or something else has been written
    public static function chooseEnv():string
    {
        $appEnv="";
        if ((int)Auth::isAdmin()===1) {
            $appEnv = 'social_admin';
        }else{
             $appEnv = 'regular';
        }
        return $appEnv;
    }
}
