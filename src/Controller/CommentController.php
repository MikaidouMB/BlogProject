<?php

namespace App\Controller;

use App\DAO\CommentManager;
use App\DAO\PostManager;
use App\DAO\UserManager;
use App\Model\Comment;
use App\Session;
use Twig\Environment;

class CommentController extends Controller
{
    private PostManager  $postManager;
    private UserManager  $userManager;
    private CommentManager $commentManager;

    public function __construct(Environment $twig)
    {
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
        $this->commentManager = new CommentManager();

        parent::__construct($twig);
    }

    public function listComments($postId): string
    {
        $comments = $this->commentManager->findCommentsByPostId($postId);
        return $this->render('Post/postsList.html.twig',['comments'=> $comments]);
    }

    /**
     * @throws \Exception
     */
    public function adminPostComments(): string
    {
        $comments = $this->commentManager->findAllComments();
        return $this->render('Admin/commentsList.html.twig',['comments'=> $comments]);
    }

    /**
     * @throws \Exception
     */
    public function commentPost($commentForm): string
    {
        if (!empty($commentForm)) {
            $comment = new Comment();
            $content = $_POST['content'];
            $sessionId = $_SESSION['newsession']['id'];
            $sessionUsername = $_SESSION['newsession']['username'];
            $postId = $_GET['id'];
            $userId = $sessionId;
            $username = $sessionUsername;
            $comment->setUserId($userId);
            $comment->setUsername($username);
            $comment->setContent($content);
            $comment->setPostId($postId);
            $comment->setIsValid(0);
            $this->postManager->find($postId);
            $this->commentManager->createComment($comment);
            Session::addMsgModeration();
            header('Location: index.php?route=posts');
            exit();
        }
        return $this->render('Post/show.html.twig', [
            'post' => $commentForm,
            ]);
    }

    /**
     * @throws \Exception
     */
    public function updateComments($id): string
    {
        $comment = $this->commentManager->find($id);
        if ($_POST) {
            $comment
                ->setContent($_POST['content']);

            if (isset($_POST['valid']))
            {
                $comment
                 ->setIsValid(1);
            }
            (new CommentManager())->update($comment);
            Session::addMsgValidation();
            header('Location: index.php?route=adminPostcomments');
            exit();
        }
        return $this->render('Admin/editComment.html.twig', ['comment' => $comment]);
    }

    public function deleteAdminPostcomments($id):void
    {
        $this->commentManager->deleteAdminPostcomments($id);
        header('Location: index.php?route=adminPostcomments');
    }

}