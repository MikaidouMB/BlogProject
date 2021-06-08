<?php

namespace App\Controller;

use App\DAO\DAO;
use App\DAO\PostManager;
use App\Model\Post;
use Twig\Environment;

class AppController extends Controller
{
    private PostManager $postManager;

    public function __construct(Environment $twig)
{
    $this->postManager = new PostManager();
    parent::__construct($twig);
}

    public function index(): string
    {
   /*     $post = new Post();
        $post
            ->setTitle('Ma maison')
            ->setContent('Bienvenue dans mon salon');

        (new PostManager())->create($post);
*/
        return $this->render('App/index.html.twig');
    }

}

