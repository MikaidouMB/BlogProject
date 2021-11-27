<?php

namespace App\Controller;

use App\DAO\CommentManager;
use App\DAO\PostManager;
use App\Model\Comment;
use App\Model\GetValue;
use App\Model\Input;
use App\Session;
use Twig\Environment;

class CommentController extends Controller
{
    private PostManager  $postManager;
    private CommentManager $commentManager;
    private Session $session;
    private Input  $input;

    public function __construct(Environment $twig, Input $input)
    {
        $this->postManager = new PostManager();
        $this->commentManager = new CommentManager();
        $this->session = new Session();
        $this->input = new Input();

        parent::__construct($twig,$input);
    }

    public function listComments($postId): string
    {
        $comments = $this->commentManager->findCommentsByPostId($postId);
        return $this->render('Post/postsList.html.twig', ['comments'=> $comments]);
    }

    /**
     * @throws \Exception
     */
    public function adminPostComments(): string
    {
        $comments = $this->commentManager->findAllComments();
        return $this->render('Admin/commentsList.html.twig', ['comments'=> $comments]);
    }

    /**
     * @throws \Exception
     */
    public function commentPost($commentForm): string
    {
        if (!empty($commentForm)) {
            $comment = new Comment();
            $content = $this->input->post('content');
            $sessionUserId = $this->session->getSessionValue('newsession', 'id');
            $sessionUsername =$this->session->getSessionValue('newsession', 'username');
            $postId = $this->input->get('id');

            $comment->setUserId($sessionUserId);
            $comment->setUsername($sessionUsername);
            $comment->setContent($content);
            $comment->setPostId($postId);
            $comment->setIsValid(0);

            $this->postManager->find($postId);
            $this->commentManager->createComment($comment);
            Session::addMsgModeration();
            header('Location: index.php?route=posts');
            Input::exitMessage();
        }
        return $this->render('Post/show.html.twig', [
            'post' => $commentForm,
            ]);
    }

    /**
     * @throws \Exception
     */
    public function updateComments($commentId): string
    {
        $comment = $this->commentManager->find($commentId);
        if ($this->input->post('content') || $this->input->post('valid')) {
            $comment
                ->setContent($this->input->post('content'));
            if ($this->input->post('valid') !== null) {
                $comment
                 ->setIsValid(1);
            }
            (new CommentManager())->update($comment);
            Session::addMsgValidation();
            header('Location: index.php?route=adminPostcomments');
            Input::exitMessage();
        }
        return $this->render('Admin/editComment.html.twig', ['comment' => $comment]);
    }

    public function deleteAdminPostcomments($postCommentId): void
    {
        $this->commentManager->deleteAdminPostcomments($postCommentId);
        header('Location: index.php?route=adminPostcomments');
    }
}
