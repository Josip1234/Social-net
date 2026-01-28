<?php

use App\Controllers\HomeController;

$_SERVER['APP_ENV']='social_admin';
require_once __DIR__.'/../bootstrap.php';


//we need to fetch user from database if user is regular then regular env should be used 
//otherwise use social admin will implement this later

$controller=new HomeController();
$page=$_GET['page']??'home/index';
switch($page){
    case 'login':
        $controller->login();
        break;
    default:
        $controller->index();
}