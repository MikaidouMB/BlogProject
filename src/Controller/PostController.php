<?php

namespace App\Controller;

use App\DAO\CommentManager;
use App\DAO\PostManager;
use App\DAO\UserManager;
use App\Model\Post;
use App\services\Session;
use Twig\Environment;

class PostController extends Controller
{
    private PostManager  $postManager;
    private UserManager $userManager;
    private CommentManager $commentManager;
    private Session $session;

    /**
     * PostController constructor.
     * @param \Twig\Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
        $this->commentManager = new CommentManager();
        $this->session = new Session();
        parent::__construct($twig);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        $posts = $this->postManager->findAll();
        return $this->render('Post/index.html.twig', ['posts' =>$posts]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function list(): string
    {
        $posts = $this->postManager->findAll();
        return $this->render('Post/list.html.twig',['posts'=> $posts]);
    }

    /**
     * @return string
     * @throws \Exception
     */
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

    /**
     * @return string
     * @throws \Exception
     */
    public function adminPostList(): string
    {
        $posts = $this->postManager->findAll();
        return $this->render('Admin/postsList.html.twig',['posts'=> $posts]);
    }

    public function adminPostUsers(): string
    {
        $users = $this->userManager->findAllUsers();
        return $this->render('Admin/usersList.html.twig',['users'=> $users]);
    }

    /**
     * @param $postForm
     * @return string
     */
    public function add($postForm): string
    {
        if (!empty($postForm)) {
            $post = new Post();
            $title = $_POST['title'];
            $content = $_POST['content'];
            $session =  $_SESSION['newsession'];
            $userId = $session->id;
            $username = $session->username;

            $post->setUserId($userId);
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

    /**
     * @param $postId
     * @return string
     * @throws \Exception
     */
    public function updateAdminPosts($postId)
    {
        $postId = (int) ($_GET['id']);
        $post   = $this->postManager->find($postId);
        if ($_POST) {
            $post->setId($postId)
                ->setAuthor($_POST['author'])
                 ->setTitle($_POST['title'])
                 ->setContent($_POST['content']);
                 (new PostManager())->updateAdminPost($post);
            header('Location: index.php?route=adminPostList');
        }

        return $this->render('Admin/editPost.html.twig', ['post' => $post]);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->postManager->delete($id);
        header('Location: index.php?route=post&id='.$id);
        echo 'post supprimé';
        header('Location: index.php?route=posts');
    }

    /**
     * @param $id
     */
    public function deleteAdminPost($id)
    {
        $this->postManager->delete($id);
        header('Location: index.php?route=adminPostList');
        echo 'post supprimé';
    }

}