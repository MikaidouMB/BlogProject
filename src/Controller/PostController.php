<?php

namespace App\Controller;

use App\DAO\CommentManager;
use App\DAO\DAO;
use App\DAO\PostManager;
use App\DAO\UserManager;
use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use App\services\Session;
use Twig\Environment;

class PostController extends Controller
{
    private PostManager  $postManager;
    private UserManager $userManager;
    private CommentManager $commentManager;

    public function __construct(Environment $twig)
    {
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
        $this->commentManager = new CommentManager();
        $this->session = new Session();

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

    public function showPostAdmin()
    {
        $post = $this->postManager->find($_GET['id']);
        $userId[] = $post->getUserId();
        $user = $this->userManager->findPostAuthorByUserId($userId);

        return $this->render('Admin/postsList.html.twig',[
            'post'=> $post,
            'user'=>$user,
        ]);
    }

    public function show(): string
    {
        $post = $this->postManager->find($_GET['id']);
        $postId[] =$post->getId();
        $userId[] = $post->getUserId();

        $user = $this->userManager->findPostAuthorByUserId($userId);
        $comments = $this->commentManager->findCommentsBypostId($postId);


        return $this->render('Post/show.html.twig',[
            'post'=> $post,
            'user'=>$user,
            'comments'=>$comments,
            ]);
    }
    public function adminPostList(): string
    {
        $posts = $this->postManager->findAll();
        return $this->render('Admin/postsList.html.twig',['posts'=> $posts]);
    }

    public function showAdminPost(): string
    {
        $post = $this->postManager->find($_GET['id']);
        $postId[] =$post->getId();
        $userId[] = $post->getUserId();

        $user = $this->userManager->findPostAuthorByUserId($userId);
        $comments = $this->commentManager->findCommentsBypostId($postId);


        return $this->render('Post/show.html.twig',[
            'post'=> $post,
            'user'=>$user,
            'comments'=>$comments,
        ]);
    }


    public function adminPostUsers(): string
    {
        $users = $this->userManager->findAllUsers();
        return $this->render('Admin/usersList.html.twig',['users'=> $users]);
    }


    public function add($postForm)
    {
        if (!empty($postForm)) {
            $post = new Post();
            $title = $_POST['title'];
            $content = $_POST['content'];
            $session =  $_SESSION['newsession'];
            $userId = $session->id;
            $post->setUserId($userId);
            $username = $session->username;
            $post->setAuthor($username);
            $post->setTitle($title);
            $post->setContent($content);
            $postForm = $this->postManager->create($post);
            echo 'post enregistré';
            header('Location: index.php?route=posts');
        }
            echo 'post pas enregistré';
            return $this->render('Post/add.html.twig', ['post' => $postForm]);
    }

  /*  public function update($id)
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
    }*/

    public function updateAdminPosts($postId)
    {
        $postId = (int) ($_GET['id']);
        $post = $this->postManager->find($postId);

        if ($_POST) {
            $post
                ->setId($postId)
                ->setTitle($_POST['title'])
                ->setContent($_POST['content']);
            (new PostManager())->updateAdminPost($post);

            header('Location: index.php?route=adminPostList');
        }
        return $this->render('Admin/editPost.html.twig', ['post' => $post]);
    }

    public function delete($id)
    {
        $post = $this->postManager->delete($id);
        header('Location: index.php?route=post&id='.$id);
        echo 'post supprimé';
        header('Location: index.php?route=posts');
    }

    public function deleteAdminPost($id)
    {
        $post = $this->postManager->delete($id);
        header('Location: index.php?route=adminPostList');
        echo 'post supprimé';
    }

}