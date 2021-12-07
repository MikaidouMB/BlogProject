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
    private Session $session;

    public function __construct(Environment $twig, Input $input, Session $session){
        $this->twig = $twig;
        $this->input = $input;
        $this->session = $session;
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $postController = new PostController($this->twig, $this->input);
        $appController = new AppController($this->twig, $this->input);
        $userController = new UserController($this->twig, $this->input);
        $commentController = new CommentController($this->twig, $this->input);

        $page = $this->input->get('route');
        $urlId = $this->input->get('id');
        $token = $this->session->getSessionValue('token');
        $roleAdmin = $this->session->getSessionValue('newsession', 'role') == 'admin';
        $this->session->getSessionValue('newsession');

        if ($page == 'posts') {
            return $postController->list();
        }
        if ($page == 'addPost') {
            return $postController->add($this->input->post());
        }
        if ($page == 'signUp') {
            return $userController->signUp($this->input->post());
        }
        if ($page == 'login') {
            return $userController->login($this->input->post());
        }
        if ($page == 'signOut') {
            return $userController->signOut();
        }
        if ($page == 'adminPostList' && $token== false) {
            return $this->twig->render('App/401page.html.twig');
        }
        if ($page == 'adminPostList' && $token == true  && $roleAdmin == true) {
            return $postController->adminPostList();
        }
        if ($page == 'adminPostcomments' && $token == false) {
            return $this->twig->render('App/401page.html.twig');
        }
        if ($page == 'adminPostcomments' && $token == true  && $roleAdmin == true) {
            return $commentController->adminPostcomments();
        }
        if ($page == 'adminPostUsers' && $token == false) {
            return $this->twig->render('App/401page.html.twig');
        }
        if ($page == 'adminPostUsers' && $token == true  && $roleAdmin == true) {
            return $postController->adminPostUsers();
        }
        if($page == 'editAdminPost' && $urlId > 0 && $token == false){
            return $this->twig->render('App/401page.html.twig');
        }
        if ($page == 'editAdminPost' && $urlId > 0 && $token == true) {
            return $postController->updateAdminPosts();
        }
        if ($page == 'editUser' && $urlId > 0 && $roleAdmin == false) {
            return $this->twig->render('App/401page.html.twig');
        }
        if ($page == 'editUser' && $urlId > 0 && $token == true  && $roleAdmin == true) {
            return $userController->updateUser();
        }
        if ($page == 'editComment' && $urlId > 0 && $roleAdmin == false) {
            return $this->twig->render('App/401page.html.twig');
        }
        if ($page == 'editComment' && $urlId > 0 && $token == true  && $roleAdmin == true) {
            return $commentController->updateComments($urlId);
         }
        if ($page == 'deleteAdminPost' && $urlId > 0) {
            return $postController->deleteAdminPost($urlId);
        }
        if ($page == 'deleteComment' && $urlId > 0) {
            return $commentController->deleteAdminPostcomments($urlId);
        }
        if ($page == 'deleteUser' && $urlId > 0) {
            return $userController->deleteUser($urlId);
        }
        if ($page == 'addComment' && $urlId > 0) {
            return $commentController->commentPost($urlId);
        }
        if ($page == 'post' && $urlId > 0) {
            return $postController->show();
        }
        if ($urlId > 0) {
            return $commentController->listComments(parse_url($urlId));
        }
        if ($page == 'adminPostViewers') {
            return $postController->listPostAuthor();
        }
        return $appController->index();
    }
}