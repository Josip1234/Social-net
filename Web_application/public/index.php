<?php

use App\Controllers\AddressController;
use App\Controllers\HomeController;
use App\Controllers\StateController;
use App\Controllers\UserController;
use Core\Config;


require_once __DIR__.'/../bootstrap.php';

//choose app env if logged in user is admin app env set to admin otherwise set it to regular user.
$_SERVER['APP_ENV']=Config::chooseEnv();


//we need to fetch user from database if user is regular then regular env should be used 
//otherwise use social admin will implement this later

$controller=new HomeController();
$userController = new UserController();
$addressController = new AddressController();
$stateController=new StateController();

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
    case 'logout':
        $controller->logout();
        break;
    case 'users/profile':
        $userController->index();
        break;
    case 'users/update':
        $userController->edit();
        break;
    case 'users/edit':
        $userController->update();
        break;
    case 'users/profile_img_update':
        $userController->updateProfileImage();
        break;
    case 'users/img_update':
        $userController->updateImg();
        break;
    case 'users/edit_account_type':
        $userController->editAccountType();
        break;
    case 'address/update':
        $addressController->updateAddress();
        break;
    case 'address/new_state':
        $stateController->stateIndex();
        break;
    case 'insertNewState':
        $stateController->insertNewState();
        break;
    default:
        $controller->index();
}