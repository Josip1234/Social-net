<?php 
use Dotenv\Dotenv;

session_start();
require_once __DIR__.'/vendor/autoload.php';
$appEnv=$_SERVER['APP_ENV']
?? $_ENV['APP_ENV']
?? 'null';
$envFile=match ($appEnv) {
    'regular' => '.env.regular',
     'social_admin'=> '.env.social_admin',
     default => 'null'
};
$dotenv=Dotenv::createImmutable(__DIR__,$envFile);
$dotenv->load();
$currentEnv=$_ENV['APP_ENV']??$appEnv;
if($currentEnv==='regular'){
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}else{
   ini_set('display_errors',0);   
}
define('APP_ENVIRONMENT',$currentEnv);