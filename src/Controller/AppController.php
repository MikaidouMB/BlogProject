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
   /*
        $post
            ->setTitle('Ma maison')
            ->setContent('Bienvenue dans mon salon');

*/
        return $this->render('App/index.html.twig');
    }
   /* public function addPost(array $t)
    {
        foreach ()
        if (isset($post['submit'])) {
            $post = new Post();
            (new PostManager())->create($post);
        }
        return $this->render('App/add.html.twig');
    }*/


}

