<?php


namespace App\Controller;

use App\DAO\CommentManager;
use App\DAO\PostManager;
use App\DAO\UserManager;
use App\Model\Comment;
use App\Model\Post;
use App\services\Session;
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
        $this->session = new Session();

        parent::__construct($twig);
    }

    public function listComments($postId): string
    {
        $comments = $this->commentManager->findCommentsBypostId($postId);
        return $this->render('Post/postsList.html.twig',['comments'=> $comments]);
    }

    public function adminPostcomments(): string
    {
        $comments = $this->commentManager->findAllComments();
        return $this->render('Admin/commentsList.html.twig',['comments'=> $comments]);
    }

    public function commentPost($commentForm)
    {
        if (!empty($commentForm)) {
            $comment = new Comment();
            $content = $_POST['content'];
            $session = new Session();
            $session =  $_SESSION['newsession'];
            $userId = $session->id;
            $username = $session->username;
            $comment->setUserId($userId);
            $comment->setUsername($username);
            $comment->setContent($content);
            $comment->setPostId($_GET['id']);

            $post = $this->postManager->find($_GET['id']);
            $postId = $post->getId();
            $commentForm = $this->commentManager->createComment($comment);

            echo 'commentaire enregistré';
            header('Location: index.php?route=post&id='.$postId);
        }
        return $this->render('Post/show.html.twig', [
            'post' => $commentForm,
        ]);
        echo 'commentaire pas enregistré';
    }

    public function updateComments($id)
    {
        $comment = $this->commentManager->find($id);
        if ($_POST) {
            $comment
                ->setContent($_POST['content']);
            (new CommentManager())->update($comment);
            header('Location: index.php?route=adminPostcomments');
        }
        return $this->render('Admin/editComment.html.twig', ['comment' => $comment]);
    }

    public function deleteAdminPostcomments($id)
    {
        $comment = $this->commentManager->deleteAdminPostcomments($id);
        header('Location: index.php?route=adminPostcomments');
        echo 'post supprimé';

    }

}