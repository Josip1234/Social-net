<?php 
namespace App\Controllers;

use App\Helpers\Validation;
use Core\Controller;

class ForumController extends Controller{
    public function home(){

        $this->view('forum/forum');
    }
    public function add_topic(){
        $this->view('forum/add_topic');
    }
    public function insert_topic(){
        $data=$_POST;
        /*
        print_r($data);
        foreach ($data as $key => $value) {
            echo $key.":".$value."<br>";
        }
        */
        $errors=[];
        $errors=Validation::validateForumInput($data);
      
        if((int)count($errors)===0){
            $_SESSION['msg']="Successfully added new topic.";
    
            header("Location: index.php?page=forum/forum");
         
        }

           $this->view("forum/add_topic",[
              "errors"=>$errors
           ]);
        
    }
}