<?php 
namespace Core;
abstract class Controller{
    //class for enabling view
    protected function view(string $view, array $data=[]):void{
            $data['activePage']=$_GET['page']??'index';
            extract($data);
            require __DIR__.'/../app/Views/layouts/header.php';
            require __DIR__.'/../app/Views/'.$view.'.php';
            require __DIR__.'/../app/Views/layouts/footer.php';
    }
}