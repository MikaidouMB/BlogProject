<?php

namespace App\Controller;

use App\DAO\UserManager;
use App\Model\User;
use Twig\Environment;

class UserController extends Controller
{
    private UserManager $userManager;

    public function __construct(Environment $twig)
    {
        $this->userManager = new UserManager();
        parent::__construct($twig);
    }

    public function login($userForm)
    {
        if (!empty($userForm)){
            if ($userForm ['username'] =="" || ($userForm ['password']=="")){
                echo 'Veuillez remplir tous les champs';
            }
            else {
                $user = new User();
                $user->setUsername($userForm ['username']);
                $user->setPassword($userForm['password']);
                $user = $this->userManager->register($user);
                echo 'Utilisateur enregistré';
            }

                //header('Location: index.php');
            }
        return $this->render('Auth/register.html.twig', ['user' => $userForm]);
    }
    /*
        public function loginPost()
        {
            $user = $this->userManager->findByUsername($_POST['username']);
            return $this->render('Auth/register.html.twig',['user'=> $user]);
            var_dump($user);
        }*/
}