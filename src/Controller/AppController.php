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
        return $this->render('App/index.html.twig');
    }

    public function postsView(): string
    {
        $posts =$this->postManager->findAll();

        return $this->render('App/posts.html.twig',['posts'=> $posts]);
    }

}

