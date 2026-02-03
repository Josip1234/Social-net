<?php 
namespace App\Controllers;
use Core\Controller;
use Core\Url;
class HomeController extends Controller{
    //instead of index, will return login page
    public function index():void{
        $this->view('home/login');
    }
    public function login():void{
        $this->view('home/login');
    }
}