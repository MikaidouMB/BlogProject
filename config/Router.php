<?php

namespace App;

use App\Controller\AppController;
use App\Controller\CommentController;
use App\Controller\PostController;
use App\Controller\UserController;
use App\Model\GetValue;
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

        if (GetValue::findGetValue('route'))
        {
            if (GetValue::findGetValue('route') == 'posts'){
                return $postController->list();
            }
            if (GetValue::findGetValue('route') == 'addPost'){
                return $postController->add(filter_input_array(INPUT_POST));
            }
            if (GetValue::findGetValue('route') == 'signUp'){
                return $userController->signUp(filter_input_array(INPUT_POST));
            }
            if (GetValue::findGetValue('route') == 'login'){
                return $userController->login(filter_input_array(INPUT_POST));
            }
            if (GetValue::findGetValue('route') == 'signOut'){
                return $userController->signOut();
            }
            if (GetValue::findGetValue('route') == 'adminPostList'){
                return $postController->adminPostList();
            }
            if(GetValue::findGetValue('route') =='editAdminPost' && GetValue::findGetValue('id') > 0){
                return $postController->updateAdminPosts();
            }
            if(GetValue::findGetValue('route') =='editUser' && GetValue::findGetValue('id') > 0) {
                return $userController->updateUser();
            }
            if (GetValue::findGetValue('route') == 'deleteAdminPost' && GetValue::findGetValue('id') > 0){
                return $postController->deleteAdminPost(GetValue::findGetValue('id'));
            }
            if (GetValue::findGetValue('route') == 'adminPostcomments'){
                return $commentController->adminPostcomments();
            }
            if (GetValue::findGetValue('route') == 'deleteComment' && GetValue::findGetValue('id') > 0){
                return $commentController->deleteAdminPostcomments(GetValue::findGetValue('id'));
            }
            if (GetValue::findGetValue('route') =='deleteUser' && GetValue::findGetValue('id') > 0){
                return $userController->deleteUser(GetValue::findGetValue('id'));
            }
            if (GetValue::findGetValue('route') == 'adminPostUsers'){
                return $postController->adminPostUsers();
            }
            if (GetValue::findGetValue('route') == 'editComment' && GetValue::findGetValue('id') > 0){
                return $commentController->updateComments(GetValue::findGetValue('id'));
            }
            if (GetValue::findGetValue('route') == 'addComment' && GetValue::findGetValue('id') > 0){
                return $commentController->commentPost(GetValue::findGetValue('id'));
            }
            if (GetValue::findGetValue('id') > 0) {
                return $postController->show();
            }
            if (GetValue::findGetValue('id') > 0) {
                return $commentController->listComments(GetValue::findGetValue('id'));
            }
        }
        return $appController->index();
    }
}