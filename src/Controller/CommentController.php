<?php

namespace App\Controller;

use App\DAO\CommentManager;
use App\DAO\PostManager;
use App\DAO\UserManager;
use App\Model\Comment;
use App\Model\GetValue;
use App\Model\PostValue;
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
            $content = PostValue::findPostValue('content');
            $sessionUserId = Session::getSessionValue('newsession','id');
            $sessionUsername = Session::getSessionValue('newsession','username');
            $postId = GetValue::findGetValue('id');
            $comment->setUserId($sessionUserId);
            $comment->setUsername($sessionUsername);
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
        if (PostValue::findPostValue('content') || PostValue::findPostValue('valid')) {
            $comment
                ->setContent(PostValue::findPostValue('content'));
            if (PostValue::findPostValue('valid') !== null)
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