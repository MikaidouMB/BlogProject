<?php

namespace App;

use App\Controller\AppController;
use Twig\Environment;

class Router
{
    private $twig;

    public function __construct(Environment $twig){
        $this->twig = $twig;
    }
    public function run(): string
    {
        $appController = new AppController($this->twig);

        if (isset($_GET['route'])) {
            if ('posts'=== $_GET['route']) {
                return $appController->postsView();
            }
        }
        return $appController->index();
    }
}