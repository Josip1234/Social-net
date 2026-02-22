<?php

use App\Controllers\HomeController;
use Core\Config;


require_once __DIR__.'/../bootstrap.php';

//choose app env if logged in user is admin app env set to admin otherwise set it to regular user.
$_SERVER['APP_ENV']=Config::chooseEnv();

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
    case 'register':
        $controller->register();
        break;
    case 'setAdmin':
        $controller->setAdmin();
        break;
    default:
        $controller->index();
}