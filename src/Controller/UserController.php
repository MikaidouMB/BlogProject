<?php

namespace App\Controller;

use App\DAO\UserManager;
use App\Model\User;
use App\services\Session;
use Twig\Environment;

class UserController extends Controller
{
    private UserManager $userManager;
    private Session $session;

    public function __construct(Environment $twig)
    {
        $this->userManager = new UserManager();
        $this->session = new Session();
        parent::__construct($twig);
    }

//Fonction permettant à l'utilisateur de s'enregistrer
    public function signUp($userForm): string
    {
        $errors = [];
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
                'userform' => $userForm,
                'errors' => $errors,
                'validation' => $validMsg,
            ]
        );
    }

    public function signOut()
    {
        if (session_id()) {
            echo 'il ya une session';
            unset($_SESSION['newsession']);
            if (empty($_SESSION)) {
                header('Location:index.php');
                echo 'la session est vide';
            }
        }
    }


    public function login($userForm): string
    {
        $errors = [];
        $validMsg = [];
        $username = false;
        $password = false;

        if (!empty($_POST)) {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                echo 'Identifiant ou mot de passe incorrect';
            } else {
                $username = $_POST['username'];
                $password = $_POST['password'];
                var_dump($userForm);
                $existUser = $this->userManager->findUser($username);
            }
            if (session_id()) {
                $_SESSION['newsession'] = $existUser;
                var_dump($existUser);
                header('Location:index.php');
                $validMsg = 'Utilisateur connecté';
            } else {
                $errors = 'Identifiant ou mot de passe inéxistant';
            }
        }
            return $this->render('Auth/login.html.twig',
                [
                    'userform' => $userForm,
                    'errors' => $errors,
                    'validation' => $validMsg,
                ]
            );

    }


}