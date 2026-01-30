<?php 
use Dotenv\Dotenv;
//session start
session_start();
//load composer autoload
require_once __DIR__.'/vendor/autoload.php';
//environment before loading env files
$appEnv=$_SERVER['APP_ENV'] ?? $_ENV['APP_ENV'] ?? 'regular';
//env file choosing
$envFile=match ($appEnv) {
     'social_admin'=> '.env.social_admin',
     'regular'=> '.env.regular',
     default => '.env.regular'
};
//load .env
$dotenv=Dotenv::createImmutable(__DIR__,$envFile);
$dotenv->load();
//safe reading APP_ENV after load
$currentEnv=$_ENV['APP_ENV']??$appEnv;
//error handling
if($currentEnv==='social_admin'){
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}else{
    ini_set('display_errors',0);
}
define('APP_ENVIRONMENT',$currentEnv);