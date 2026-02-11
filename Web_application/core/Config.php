<?php

namespace Core;

class Config
{
    //this function returns app env if there is no key defined it returns default
    //default is regular user
    public static function get(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
    //this function will set env variables depending on registered user and what type user is
    //if app env has not been set set regular user automaticly 
    // or something else has been written
    public static function chooseEnv()
    {
        if ($_SERVER['APP_ENV'] === '' || $_SERVER['APP_ENV'] !== 'social_admin') {
            $_SERVER['APP_ENV'] = 'regular';
        }else if((int)Auth::isAdmin()===1){
             $_SERVER['APP_ENV'] = 'social_admin';
        }
    }
}
