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

    /**
     * @param $userForm
     * @return string
     */
    public function signUp($userForm): string
    {
        $errors = [];
        $validMsg = [];
        $error_user = [];

        if (!empty($_POST)) {
            if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
                $errors = 'Les champs sont vides';
            } else {
                    $user = new User();
                    $password = $_POST['password'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $user->setUsername($username);
                    $user->setPassword($hashedPassword);
                    $user->setEmail($email);
                    $user->setRole('viewer');
                    $existingUser = $this->userManager->checkIfUserExist($username);

                if (empty($existingUser)) {

                    $this->userManager->register($user);
                    $_SESSION['newsession']['inscription'] = "Bienvenue";
                    header('Location:index.php');
                    $this->login($user);
                    exit();
                } else {
                    $error_user = 'Ce nom d\'utilisateur existe déjà';
                }
            }
        }

        return $this->render('Auth/register.html.twig',
            [
                'userform' => $userForm,
                'errors' => $errors,
                'errorsUser' => $error_user,
                'validation' => $validMsg,
            ]
        );
    }

    public function signOut()
    {
        if (session_id()) {
            unset($_SESSION['newsession']);
            if (empty($_SESSION['newsession'])) {
                $_SESSION['newsession']['deconnection'] = "Vous êtes déconnecté";
                header('Location:index.php');
                exit();
            }
        }
    }

    /**
     * @param $userForm
     * @return string
     */
    public function login($userForm): string
    {
        $errors = [];
        $validMsg = [];

        if (!empty($_POST)) {
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $errors =  'Identifiant ou mot de passe incorrect';
            }
            else {
                $username = $_POST['username'];
                $existingUser = $this->userManager->checkIfUserExist($username);
            }

            if (session_id() && isset($existingUser)) {
                $_SESSION['newsession'] = $existingUser;
                $_SESSION['newsession']['confirmation'] = "Connexion effectuée";
                header('Location:index.php?connexion');
            exit();
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

    /**
     * @param $userId
     * @return string
     */
    public function updateUser($userId): string
    {
        $userId =  array($_GET['id']);
        $user = $this->userManager->findPostAuthorByUserId($userId);

        if (isset($_POST['user_id'])){
            if ($_POST['user_id'] == 1) {
                $user->setRole('viewer');
            } elseif ($_POST['user_id'] == 2) {
                $user->setRole('admin');
            }
            (new UserManager())->update($user);
            $_SESSION['newsession']['update_user'] = "Utilisateur mis à jour";
            header('Location: index.php?route=adminPostUsers');
            exit();
        }
        return $this->render('Admin/editUser.html.twig', ['user' => $user]);
    }

    /**
     * @param $userId
     */
    public function deleteUser($userId)
    {
        $this->userManager->delete($userId);
        header('Location: index.php?route=adminPostUsers');
    }

}