<?php 
namespace App\Controllers;

use Core\Controller;

class ForumController extends Controller{
    public function home(){
        $this->view('forum/forum');
    }
}