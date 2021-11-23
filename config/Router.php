<?php

namespace App;

use App\Controller\AppController;
use App\Controller\CommentController;
use App\Controller\PostController;
use App\Controller\UserController;
use Twig\Environment;

class Router
{
    private Environment $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $postController = new PostController($this->twig);
        $appController  = new AppController($this->twig);
        $userController = new UserController($this->twig);
        $commentController = new CommentController($this->twig);


        if (isset($_GET['route']))
        {
            if ('posts' === $_GET['route'] ) {
                return $postController->list();
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
            if ('adminPostList'=== $_GET['route']){
                return $postController->adminPostList($_POST);
            }
            if ('editAdminPost' == $_GET['route']&& (isset($_GET['id']) && $_GET['id'] > 0 )) {
                return $postController->updateAdminPosts($_GET['id']);
            }
            if ($_GET['route']== 'editUser' && (isset($_GET['id']) && $_GET['id'] > 0 )){
                return $userController->updateUser($_POST);
            }
            if ($_GET['route'] === 'deleteAdminPost' && (isset($_GET['id']) && $_GET['id'] > 0)){
                return $postController->deleteAdminPost($_GET['id']);
            }
            if ('adminPostcomments'=== $_GET['route']){
                return $commentController->adminPostcomments($_POST);
            }
            if ($_GET['route'] === 'deleteComment' && (isset($_GET['id']) && $_GET['id'] > 0)){
                return $commentController->deleteAdminPostcomments($_GET['id']);
            }
            if ($_GET['route']=='deleteUser' && (isset($_GET['id']) && $_GET['id'] > 0)){
                return $userController->deleteUser($_GET['id']);
            }
            if ('adminPostUsers'=== $_GET['route']){
                return $postController->adminPostUsers();
            }
            if ($_GET['route']== 'editComment' && (isset($_GET['id']) && $_GET['id'] > 0 )){
                return $commentController->updateComments($_GET['id']);
            }
            if ($_GET['route']== 'addComment' && (isset($_GET['id']) && $_GET['id'] > 0 )){
                return $commentController->commentPost($_GET['id']);
            }
            if (isset($_GET['id']) && $_GET['id'] > 0 ) {
                return $postController->show($_POST);
            }
            if (isset($_GET['id']) && $_GET['id'] > 0 ) {
                return $commentController->listComments();
            }
        }
                return $appController->index();
    }
}