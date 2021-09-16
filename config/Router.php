<?php

namespace App;

use App\Controller\AppController;
use App\Controller\PostController;
use App\Controller\UserController;
use Twig\Environment;

class Router
{
    private $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }
    public function run()
    {
        $postController = new PostController($this->twig);
        $appController  = new AppController($this->twig);
        $userController = new UserController($this->twig);


        if (isset($_GET['route']))
        {
            if ('posts' === $_GET['route']) {
                return $postController->list();
            }
            if ($_GET['route']== 'editPost' && (isset($_GET['id']) && $_GET['id'] > 0 )){
            return $postController->update($_GET['id']);
            }
            if ($_GET['route']=='deletePost' && (isset($_GET['id']) && $_GET['id'] > 0)){
                return $postController->delete($_GET['id']);
            }
            if (isset($_GET['id']) && $_GET['id'] > 0 ) {
                return $postController->show();
            }
           if ('addPost' === $_GET['route']) {
                   return $postController->add($_POST);
            }
            if ('signUp'=== $_GET['route']){
                return $userController->signUp($_POST);
            }
            if ('login'=== $_GET['route']){
                return $userController->login($_POST);
            }
            if ('signOut'=== $_GET['route']){
                return $userController->signOut($_POST);
            }
            if ('admin'=== $_GET['route']){
                return $postController->administration($_POST);
            }
        }
                return $appController->index();
    }
}