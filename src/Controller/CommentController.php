<?php


namespace App\Controller;

use App\DAO\CommentManager;
use App\DAO\PostManager;
use App\DAO\UserManager;
use App\Model\Comment;
use App\Model\Post;
use Twig\Environment;

class CommentController extends Controller
{
    private PostManager  $postManager;
    private UserManager $userManager;
    private CommentManager $commentManager;

    public function __construct(Environment $twig)
    {
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
        $this->commentManager = new CommentManager();

        parent::__construct($twig);
    }

    public function commentPost($commentForm)
    {
        if (!empty($commentForm)) {
            $comment = new Comment();
            $content = $_POST['content'];
            $comment->setContent($content);
            $comment->setPostId($_GET['id']);
            $commentForm = $this->commentManager->createComment($comment);
            var_dump($comment);
            var_dump($commentForm);
            echo 'commentaire enregistré';
            //header('Location: index.php?route=posts');
        }
        echo 'commentaire pas enregistré';
        return $this->render('Post/show.html.twig', ['post' => $commentForm]);
    }

    public function listComments(): string
    {
        $comment = $this->commentManager->findAll();
        return $this->render('Post/show.html.twig',['comment'=> $comment]);
    }
}