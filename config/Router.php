<?php

namespace App;

use App\Controller\AppController;
use App\Controller\CommentController;
use App\Controller\PostController;
use App\Controller\UserController;
use App\Model\getUrl;
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

        if (getUrl::getRoute('route'))
        {
            if (getUrl::getRoute('route') == 'posts'){
                return $postController->list();
            }
            if (getUrl::getRoute('route') == 'addPost'){
                return $postController->add($_POST);
            }
            if (getUrl::getRoute('route') == 'signUp'){
                return $userController->signUp($_POST);
            }
            if (getUrl::getRoute('route') == 'login'){
                return $userController->login($_POST);
            }
            if (getUrl::getRoute('route') == 'signOut'){
                return $userController->signOut();
            }
            if (getUrl::getRoute('route') == 'adminPostList'){
                return $postController->adminPostList();
            }
            if(getUrl::getRoute('route') =='editAdminPost' && getUrl::getRoute('id') > 0){
                return $postController->updateAdminPosts();
            }
            if(getUrl::getRoute('route') =='editUser' && getUrl::getRoute('id') > 0) {
                return $userController->updateUser();
            }
            if (getUrl::getRoute('route') == 'deleteAdminPost' && getUrl::getRoute('id') > 0){
                return $postController->deleteAdminPost(getUrl::getRoute('id'));
            }
            if (getUrl::getRoute('route') == 'adminPostcomments'){
                return $commentController->adminPostcomments();
            }
            if (getUrl::getRoute('route') == 'deleteComment' && getUrl::getRoute('id') > 0){
                return $commentController->deleteAdminPostcomments(getUrl::getRoute('id'));
            }
            if (getUrl::getRoute('route') =='deleteUser' && getUrl::getRoute('id') > 0){
                return $userController->deleteUser(getUrl::getRoute('id'));
            }
            if (getUrl::getRoute('route') == 'adminPostUsers'){
                return $postController->adminPostUsers();
            }
            if (getUrl::getRoute('route') == 'editComment' && getUrl::getRoute('id') > 0){
                return $commentController->updateComments(getUrl::getRoute('id'));
            }
            if ($_GET['route']== 'addComment' && getUrl::getRoute('id') > 0){
                return $commentController->commentPost(getUrl::getRoute('id'));
            }
            if (getUrl::getRoute('id') > 0) {
                return $postController->show();
            }
            if (getUrl::getRoute('id') > 0) {
                return $commentController->listComments(getUrl::getRoute('id'));
            }
        }
        return $appController->index();
    }
}