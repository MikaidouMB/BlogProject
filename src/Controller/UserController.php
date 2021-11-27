<?php

namespace App\Controller;

use App\DAO\UserManager;
use App\Model\GetValue;
use App\Model\User;
use App\Model\Input;
use Twig\Environment;
use App\Session;

class UserController extends Controller
{
    private UserManager $userManager;
    private Input  $input;
    public function __construct(Environment $twig, Input $input)
    {
        $this->userManager = new UserManager();
        $this->input = new Input();
        parent::__construct($twig,$input);
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

        if (!empty($this->input->post('username'))
            || empty($this->input->post('password'))
            || empty($this->input->post('email'))) {
            if (empty($this->input->post('username'))
                || empty($this->input->post('password'))
                || empty($this->input->post('email'))) {
                $errors = 'Les champs sont vides';
            }
            $user = new User();
            $password = $this->input->post('password');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
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
                Input::exitMessage();
            } else {
                $error_user = 'Ce nom d\'utilisateur existe déjà';
            }
        }
        return $this->render(
            'Auth/register.html.twig',
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
        Input::exitMessage();
    }

    /**
     * @param $userForm
     * @return string
     */
    public function login($userForm): string
    {
        $errors = [];
        $validMsg = [];

        if (!empty($this->input->post('username')) || empty($this->input->post('password'))) {
            if (empty($this->input->post('username')) || empty($this->input->post('password'))) {
                $errors = 'Identifiant ou mot de passe incorrect';
            } else {
                $username = $this->input->post('username');
                $existingUser = $this->userManager->checkIfUserExist($username);
            }

            if (isset($existingUser)) {
                Session::set('newsession', $existingUser);
                Session::addMsgConn();
                header('Location:index.php?connexion');
                Input::exitMessage();
            }
        }

        return $this->render(
            'Auth/login.html.twig',
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
        $userId =  array($this->input->get('id'));
        $user = $this->userManager->findPostAuthorByUserId($userId);

        if ($this->input->post('user_id')) {
            if ($this->input->post('user_id') == 1) {
                $user->setRole('viewer');
            } elseif ($this->input->post('user_id') == 2) {
                $user->setRole('admin');
            }
            Session::addMsgUpdateUser();
            (new UserManager())->update($user);
            header('Location: index.php?route=adminPostUsers');
            Input::exitMessage();
        }
        return $this->render('Admin/editUser.html.twig', ['user' => $user]);
    }

    /**
     * @param $userId
     */
    public function deleteUser($userId): void
    {
        $this->userManager->delete($userId);
        header('Location: index.php?route=adminPostUsers');
    }
}