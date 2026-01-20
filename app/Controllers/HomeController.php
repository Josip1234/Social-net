<?php 
namespace App\Controllers;
use Core/Controller;

public function index():void{
    $this->view('/home/index');
}