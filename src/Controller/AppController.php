<?php
namespace App\Controller;

use App\DAO\PostManager;
use App\DAO\UserManager;
use App\Model\Input;
use Twig\Environment;

class AppController extends Controller
{
    private PostManager $postManager;
    private UserManager $userManager;

    public function __construct(Environment $twig, Input $input)
    {
        $this->postManager = new PostManager();
        $this->userManager = new UserManager();
        parent::__construct($twig,$input);
    }

    public function index(): string
    {
        return $this->render('App/index.html.twig');
    }
}