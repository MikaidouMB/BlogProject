<?php

namespace App\Controller;

use App\DAO\DAO;
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
                $user->setRole('viewer');
                $existingUser = $this->userManager->checkIfUserExist($username);
                if (empty($existingUser)) {
                    $this->userManager->register($user);
                    $_SESSION['newsession'] = $user;
                    header('Location:index.php');

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

        if (!empty($_POST)) {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                echo 'Identifiant ou mot de passe incorrect';
            } else {
                $username = $_POST['username'];
                $existingUser = $this->userManager->checkIfUserExist($username);
            }

            if (session_id() && $existingUser !== null) {
                $_SESSION['newsession'] = $existingUser;
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

    public function updateUser($userId)
    {
        $userId =  array($_GET['id']);
        $user = $this->userManager->findPostAuthorByUserId($userId);

        if (isset($_POST['user_id'])){
            if ($_POST['user_id'] == 1) {
                $user->setRole('viewver');

            } elseif ($_POST['user_id'] == 2) {
                $user->setRole('admin');
            }

            (new UserManager())->update($user);
            header('Location: index.php?route=adminPostUsers');
        }

        return $this->render('Admin/editUser.html.twig', ['user' => $user]);
    }

    public function deleteUser($userId)
    {
        $this->userManager->delete($userId);
        header('Location: index.php?route=adminPostUsers');
        echo 'post supprimé';
    }

}