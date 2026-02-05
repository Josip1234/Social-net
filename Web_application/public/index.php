<?php

use App\Controllers\HomeController;

$_SERVER['APP_ENV']='';
//if app env has not been set set regular user automaticly 
// or something else has been written
if($_SERVER['APP_ENV']==='' || $_SERVER['APP_ENV']!=='social_admin'){
    $_SERVER['APP_ENV']='regular';
}
require_once __DIR__.'/../bootstrap.php';


//we need to fetch user from database if user is regular then regular env should be used 
//otherwise use social admin will implement this later

$controller=new HomeController();
$page=$_GET['page']??'index';
switch($page){
    case 'index':
        $controller->index();
        break;
    case 'login':
        //get login form process form if they have post data
        $controller->login();
        break;
    default:
        $controller->index();
}