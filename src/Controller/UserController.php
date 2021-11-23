<?php

namespace App\Controller;

use App\DAO\UserManager;
use App\Model\GetValue;
use App\Model\PostValue;
use App\Model\User;
use Twig\Environment;
use App\Session;

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
            if (empty(PostValue::findPostValue('username'))
                || empty(PostValue::findPostValue('password'))
                || empty(PostValue::findPostValue('email'))) {
                $errors = 'Les champs sont vides';
            } else {
                $user = new User();
                $password = PostValue::findPostValue('password');
                $username = PostValue::findPostValue('username');
                $email = PostValue::findPostValue('email');
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $user->setUsername($username);
                $user->setPassword($hashedPassword);
                $user->setEmail($email);
                $user->setRole('viewer');
                $existingUser = $this->userManager->checkIfUserExist($username);

                if (empty($existingUser)) {
                    $this->userManager->register($user);
                    Session::set('newsession', $user);
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

    public function signOut(): void
    {
        Session::destroySession();
        Session::addMsgDeco();
        header('Location:index.php');
        exit();
    }

    /**
     * @param $userForm
     * @return string
     */
    public function login($userForm): string
    {
        $errors = [];
        $validMsg = [];

        if (!empty(PostValue::findPostValue('username')) || empty(PostValue::findPostValue('password'))){
            if (empty(PostValue::findPostValue('username')) || empty(PostValue::findPostValue('password'))){
                $errors = 'Identifiant ou mot de passe incorrect';
        } else {
            $username = PostValue::findPostValue('username');
            $existingUser = $this->userManager->checkIfUserExist($username);
        }

        if (isset($existingUser)) {
            Session::set('newsession', $existingUser);
            Session::addMsgConn();
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
     * @return string
     */
    public function updateUser(): string
    {
        $userId =  array(GetValue::findGetValue('id'));
        $user = $this->userManager->findPostAuthorByUserId($userId);

        if (PostValue::findPostValue('user_id')){
            if (PostValue::findPostValue('user_id') == 1) {
                $user->setRole('viewer');
            } elseif (PostValue::findPostValue('user_id') == 2) {
                $user->setRole('admin');
            }
            Session::addMsgUpdateUser();
            (new UserManager())->update($user);
            header('Location: index.php?route=adminPostUsers');
            exit();
        }
        return $this->render('Admin/editUser.html.twig', ['user' => $user]);
    }

    /**
     * @param $userId
     */
    public function deleteUser($userId):void
    {
        $this->userManager->delete($userId);
        header('Location: index.php?route=adminPostUsers');
    }
}