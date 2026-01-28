<?php 
namespace App\Controllers;
use Core\Controller;
use Core\Url;
class HomeController extends Controller{
    public function index():void{
        $this->view('home/index');
    }
    public function login():void{
        $this->view('home/login');
    }
}