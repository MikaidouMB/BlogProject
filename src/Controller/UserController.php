<?php

namespace App\Controller;

use App\DAO\UserManager;
use App\Model\User;
use App\Model\Input;
use Twig\Environment;
use App\Session;

class UserController extends Controller
{
    private UserManager $userManager;
    private Input $input;

    public function __construct(Environment $twig, Input $input)
    {
        $this->userManager = new UserManager();
        $this->input = new Input();
        parent::__construct($twig, $input);
    }

    /**
     * @param $userForm
     * @return string
     */
    public function signUp($userForm): string
    {
        $validMsg = [];
        $errorField = [];
        $errorUsername = [];

        if ($this->input->post('username') === '' ||
            $this->input->post('password') === '' ||
            $this->input->post('email') === '')
        {
            $errorField = 'Vous devez remplir tous les champs';
        }

        if (!empty($this->input->post('username'))
            && !empty($this->input->post('password'))
            && !empty($this->input->post('email')))
        {
            $user = new User();
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setUsername($username);
            $user->setPassword($hashedPassword);
            $user->setEmail($email);
            $user->setRole('viewer');
            $user->setIsValid(0);
            $existingUser = $this->userManager->checkIfUserExist($username);

            if ($existingUser !== null) {
                $errorUsername ='Ce nom d\'utilisateur existe déjà';
            }
            if ($existingUser === null) {
                $this->userManager->register($user);
                Session::set('newsession', $user);
                $this->login($user);
                header('Location:index.php');
                Input::exitMessage();
            }
        }
        return $this->render(
            'Auth/register.html.twig',
            [
                'userform' => $userForm,
                'errorUsername' => $errorUsername,
                'errorField' => $errorField,
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
        $errorUsername = [];
        $errors = [];
        $validMsg = [];
        $errorField = [];

        if ($this->input->post('username') === '' || $this->input->post('password') === '') {
            $errorField = 'Vous devez remplir tous les champs';
        }

        $username = $this->input->post('username');
        $existingUser = $this->userManager->checkIfUserExist($username);

        if (!empty($this->input->post('username')) || !empty($this->input->post('password'))) {
            if ($existingUser == null) {
                $errorUsername = 'Cet identifiant n\'existe pas';
            }
            if ($existingUser != null) {
                Session::set('newsession', $existingUser);
                Session::addMsgConn();
                header('Location:index.php?connexion');
                Input::exitMessage();
            }
        }
        return $this->render(
            'Auth/login.html.twig',
            [
                'errorUsername' => $errorUsername,
                'errorField' => $errorField,
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
            if ($this->input->post('valid') !== null) {
                $user
                    ->setIsValid(1);
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