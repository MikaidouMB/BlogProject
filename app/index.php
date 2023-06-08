<?php

use App\Model\Input;
use App\Router;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Session;

require 'vendor/autoload.php';

/*$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');*/

     $loader = new FilesystemLoader('/home/mikaidou/projets OC/MM_P5_creez-votre-premier-blog-en-php_2021-12-09T195931/P5_mbo_mikaidou/P5_02_blog/app/templates');
     $twig = new Environment($loader, ['debug' => true]);
     $twig->addExtension(new DebugExtension());
     $input = new Input();
     $session = new Session();

    try {
        print_r((new Router($twig, $input, $session))->run()) ;
    } catch (Exception $e) {}

    if (Session::getMessage('newsession','message','connection')) {
        Session::destroyMsg();
    } elseif (Session::getMessage('newsession','message','deconnection')) {
        Session::destroyMsg();
    } elseif (Session::getMessage('newsession','message','update_user')) {
        Session::destroyMsg();
    } elseif (Session::getMessage('newsession','message','moderation')) {
        Session::destroyMsg();
    } elseif (Session::getMessage('newsession','message','update_comment')) {
        Session::destroyMsg();
    } elseif (Session::getMessage('newsession','message','article_update')) {
        Session::destroyMsg();
    } elseif (Session::getMessage('newsession','message','add')) {
        Session::destroyMsg();
    }
