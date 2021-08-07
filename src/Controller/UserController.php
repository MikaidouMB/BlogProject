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

    public function signUp($userForm): string
    {
        $errors   = [];
        $validMsg = [];

        if (!empty($_POST)) {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $errors = 'Les champs sont vides';
            } else {
                        $user = new User();
                        $password = $_POST['password'];
                        $username = $_POST['username'];
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $user->setUsername($username);
                        $user->setPassword($hashedPassword);
                        $existUser = $this->userManager->findUser($username);

                        if (empty($existUser)) {
                            $this->userManager->register($user);
                            $validMsg = 'Utilisateur enregistré';
                        } else {
                        echo "L'utilisateur existe déjà";
                        }
                    }
        }
        return $this->render('Auth/register.html.twig',
            [
                'userform'   => $userForm,
                'errors'     => $errors,
                'validation' => $validMsg,
            ]
        );
    }
    public function login($userForm): string
    {
        $errors   = [];
        $validMsg = [];
        $username = false;

        if (!empty($_POST)){
            if (empty($_POST['username']) || empty($_POST['password'])) {
                echo 'Identifiant ou mot de passe incorrect';
            }else {
                $username  = $_POST['username'];
                $existUser = $this->userManager->findUser($username);
                if (isset($existUser)) {
                    $validMsg = 'Utilisateur connecté';
                } else {
                    $errors = 'Identifiant ou mot de passe inéxistant';
                }
            }
        }
        return $this->render('Auth/login.html.twig',
            [
                'userform'   => $userForm,
                'errors'     => $errors,
                'validation' => $validMsg,
            ]
        );

    }


    public function loginPost()
        {
            $user = $this->userManager->findByUsername($_POST['username']);
            return $this->render('Auth/register.html.twig',['user'=> $user]);
            var_dump($user);
        }


}