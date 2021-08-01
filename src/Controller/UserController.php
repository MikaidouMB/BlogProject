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

    public function signUp($userForm)
    {
        $errors = [];
        $validMsg = [];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        var_dump($hashed_password);

        if (!empty($_POST)){
            if ($_POST['username'] == '' || ($_POST ['password'] == '')){
                $errors =  'Les champs sont vides';

            }
            else {
                $user = new User();
                $user->setUsername($userForm ['username']);
                $user->setPassword($userForm['password']);

                $user = $this->userManager->register($user);
                var_dump($userForm);
                $validMsg = 'Utilisateur enregistré';
            }
        }
        return $this->render('Auth/register.html.twig', [
            'userform' => $userForm, 'errors'=> $errors, 'validation'=> $validMsg, 'password'=>$password]);
    }

    public function login($userForm)
    {
        $errors = [];
        $u = [];
        if (!empty($_POST)){
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $errors= 'Identifiant ou mot de passe incorrect';
            }elseif (!empty($_POST['username']) || empty($_POST['password'])){
                $user = new User();
                $user = $this->userManager->findByUsername($userForm['username'] && $userForm['password']);
                var_dump($user);
                if (is_null($user)){
                    echo 'user non trouvé';
                }else{
                    echo 'utilisateur trouvé';
                }

            }
        }
        return $this->render('Auth/login.html.twig', ['userform' => $userForm, 'errors'=> $errors]);

    }


    public function loginPost()
        {
            $user = $this->userManager->findByUsername($_POST['username']);
            return $this->render('Auth/register.html.twig',['user'=> $user]);
            var_dump($user);
        }


}