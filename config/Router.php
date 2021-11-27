<?php

namespace App;

use App\Controller\AppController;
use App\Controller\CommentController;
use App\Controller\PostController;
use App\Controller\UserController;
use App\Model\Input;
use Twig\Environment;

class Router
{
    private Environment $twig;
    private Input $input;

    public function __construct(Environment $twig, Input $input){
        $this->twig = $twig;
        $this->input = $input;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $postController = new PostController($this->twig,$this->input);
        $appController  = new AppController($this->twig,$this->input);
        $userController = new UserController($this->twig,$this->input);
        $commentController = new CommentController($this->twig,$this->input);
        $input = new Input();

        if ($input->get('route'))
        {
            if ($this->input->get('route') == 'posts'){
                return $postController->list();
            }
            if ($this->input->get('route') == 'addPost'){
                return $postController->add($this->input->post());
            }
            if ($this->input->get('route') == 'signUp'){
                return $userController->signUp($this->input->post());
            }
            if ($this->input->get('route') == 'login'){
                return $userController->login($this->input->post());
            }
            if ($this->input->get('route') == 'signOut'){
                return $userController->signOut();
            }
            if ($this->input->get('route') == 'adminPostList'){
                return $postController->adminPostList();
            }
            if ($this->input->get('route') =='editAdminPost' && $this->input->get('id') > 0){
                return $postController->updateAdminPosts();
            }
            if ($this->input->get('route') =='editUser' && $this->input->get('id') > 0) {
                return $userController->updateUser();
            }
            if ($this->input->get('route') == 'deleteAdminPost' && $this->input->get('id') > 0){
                return $postController->deleteAdminPost($this->input->get('id'));
            }
            if ($this->input->get('route') == 'adminPostcomments'){
                return $commentController->adminPostcomments();
            }
            if ($this->input->get('route') == 'deleteComment' && $this->input->get('id') > 0){
                return $commentController->deleteAdminPostcomments($this->input->get('id'));
            }
            if ($this->input->get('route') =='deleteUser' && $this->input->get('id') > 0){
                return $userController->deleteUser($this->input->get('id'));
            }
            if ($this->input->get('route') == 'adminPostUsers'){
                return $postController->adminPostUsers();
            }
            if ($this->input->get('route') == 'editComment' && $this->input->get('id') > 0){
                return $commentController->updateComments($this->input->get('id'));
            }
            if ($this->input->get('route') == 'addComment' && $this->input->get('id') > 0){
                return $commentController->commentPost($input->get('id'));
            }
            if ($this->input->get('id') > 0) {
                return $postController->show();
            }
            if ($this->input->get('id') > 0) {
                return $commentController->listComments($this->input->get('id'));
            }
        }
        return $appController->index();
    }
}