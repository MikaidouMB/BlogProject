<?php

namespace App;

use App\Controller\AppController;
use App\Controller\PostController;
use App\Model\Post;
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
        $appController = new AppController($this->twig);

        if (isset($_GET['route']))
        {
            if ('posts'=== $_GET['route']) {
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

        }
                return $appController->index();
    }
}