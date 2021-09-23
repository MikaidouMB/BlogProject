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

    public function administration(): string
    {
        $posts = $this->postManager->findAll();
        return $this->render('Post/administration.html.twig',['posts'=> $posts]);
    }

    public function add($postForm)
    {
        if (!empty($postForm)) {
            $post = new Post();
            $title = $_POST['title'];
            $content = $_POST['content'];
            $post->setTitle($title);
            $post->setContent($content);
            $newPost = $this->postManager->create($post);
            echo 'post enregistré';
            $newPost = (array) $newPost[2];
            $merge = array_merge($newPost,$postForm);
            $postForm = $merge;
            var_dump($postForm);
            //header('Location: index.php?route=posts');
        }
            echo 'post pas enregistré';
            return $this->render('Post/add.html.twig', ['post' => $postForm]);
    }

    public function update($id)
    {
        $post = $this->postManager->find($id);
        if ($_POST) {
            $post
                ->setTitle($_POST['title'])
                ->setContent($_POST['content']);
            (new PostManager())->update($post);
            header('Location: index.php?route=post&id='.$id);
        }
        return $this->render('Post/edit.html.twig', ['post' => $post]);
    }

    public function delete($id)
    {
        $post = $this->postManager->delete($id);
        header('Location: index.php?route=post&id='.$id);
        echo 'post supprimé';
        header('Location: index.php?route=posts');
    }


}