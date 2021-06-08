<?php

namespace App\Controller;

use App\DAO\PostManager;
use Twig\Environment;

class PostController extends Controller
{
    private PostManager  $postManager;

    public function __construct(Environment $twig)
    {
        $this->postManager = new PostManager();
        parent::__construct($twig);
    }

    public function index()
    {
        $posts = $this->postManager->findAll();
        return $this->render('Post/index.html.twig', ['posts' =>$posts]);

    }

    public function list(): string
    {
        $posts = $this->postManager->findAll();

        return $this->render('Post/list.html.twig',['posts'=> $posts]);
    }

    public function show()
    {
        $post = $this->postManager->find($_GET['id']);

        return $this->render('Post/show.html.twig',['post'=> $post]);
    }
}