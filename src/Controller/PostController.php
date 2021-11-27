<?php

namespace App\Controller;

use App\DAO\CommentManager;
use App\DAO\PostManager;
use App\DAO\UserManager;
use App\Model\GetValue;
use App\Model\Input;
use App\Model\Post;
use App\Session;
use Twig\Environment;

class PostController extends Controller
{
    private PostManager  $postManager;
    private UserManager $userManager;
    private CommentManager $commentManager;
    private Input $input;
    private Session $session;

    /**
     * PostController constructor.
     * @param \Twig\Environment $twig
     * @param \App\Model\Input $input
     */
    public function __construct(Environment $twig, Input $input)
    {
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
        $this->commentManager = new CommentManager();
        $this->input = new Input();
        $this->session = new Session();

        parent::__construct($twig, $input);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function list(): string
    {
        $posts = $this->postManager->findAll();
        return $this->render('Post/list.html.twig', ['posts'=> $posts]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function show(): string
    {
        $post = $this->postManager->find($this->input->get('id'));
        $postId[] = $post->getId();
        $userId[] = $post->getUserId();

        $user = $this->userManager->findPostAuthorByUserId($userId);
        $comments = $this->commentManager->findCommentsByPostId($postId);

        return $this->render('Post/show.html.twig', [
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
        return $this->render('Admin/postsList.html.twig', ['posts'=> $posts]);
    }

    public function adminPostUsers(): string
    {
        $users = $this->userManager->findAllUsers();
        return $this->render('Admin/usersList.html.twig', ['users'=> $users]);
    }

    /**
     * @param $postForm
     * @return string
     */
    public function add($postForm): string
    {
        if (!empty($postForm)) {
            $post = new Post();
            $title = $this->input->post('title');
            $content = $this->input->post('content');
            $sessionUserId = $this->session->getSessionValue('newsession', 'id');
            $sessionUsername = $this->session->getSessionValue('newsession', 'username');
            $post->setUserId($sessionUserId);
            $post->setAuthor($sessionUsername);
            $post->setTitle($title);
            $post->setContent($content);
            $this->postManager->create($post);
            Session::addMsgCreatePost();
            header('Location: index.php?route=posts');
            $this->input->get();
        }
        return $this->render('Post/add.html.twig', ['post' => $postForm]);
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function updateAdminPosts(): string
    {
        $postId = (int) ($this->input->get('id'));
        $post = $this->postManager->find($postId);

        if ($this->input->post('title')
            || $this->input->post('content')
            || $this->input->post('author')) {
            $post->setId($postId)
                 ->setAuthor($this->input->post('author'))
                 ->setTitle($this->input->post('title'))
                 ->setContent($this->input->post('content'));
            (new PostManager())->updateAdminPost($post);
            Session::addMsgUpdatePost();
            header('Location: index.php?route=adminPostList');
            Input::exitMessage();
        }
        return $this->render('Admin/editPost.html.twig', ['post' => $post]);
    }

    /**
     * @param $postId
     */
    public function delete($postId)
    {
        $this->postManager->delete($postId);
        header('Location: index.php?route=post&id='.$postId);
    }

    /**
     * @param $postId
     */
    public function deleteAdminPost($postId): void
    {
        $this->postManager->delete($postId);
        header('Location: index.php?route=adminPostList');
    }
}
