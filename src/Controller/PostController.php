<?php

namespace App\Controller;

use App\DAO\PostManager;
use App\Model\Post;
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
    public function add($postForm)
    {
        if (!empty($postForm)) {
            $post = new Post();
            $post->setTitle($postForm ['title']);
            $post->setContent($postForm['content']);
            $post = $this->postManager->create($post);
            echo 'post enregistré';
            return $this->render('App/index.html.twig', ['post' => $post]);
        }
            echo 'post pas enregistré';
            return $this->render('Post/add.html.twig', ['post' => $postForm]);
    }



    public function update($id)
    {
        $post = $this->postManager->find($id);
        if ($_POST){
            var_dump($post);
            //$title = $post['title'];
            $post = new Post();
            $post->setId($id);
            $post->setTitle($_POST['title']);
            $post->setContent($_POST['content']);
            $post->setCreatedAt(new \DateTimeImmutable('now'));

            //var_dump($post);die;
            $this->postManager->update($post);
        }
        return $this->render('Post/edit.html.twig', ['post' => $post]);

    }
    public function delete()
    {

    }

}