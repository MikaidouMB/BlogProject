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
    public function run(): string
    {
        $postController = new PostController($this->twig);
        $appController = new AppController($this->twig);

        if (isset($_GET['route']))
        {
            if ('posts'=== $_GET['route']) {
                return $postController->list();
            }
            if (isset($_GET['id']) && $_GET['id'] > 0 ) {
                return $postController->show();
            }
           if ('addPost'=== $_GET['route']) {
                   return $postController->add($_POST);
            }
            if ('updatePost'=== $_GET['route']) {
                return $postController->update($_POST);
            }
        }
                return $appController->index();
    }
}