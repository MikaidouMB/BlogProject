<?php

use App\Router;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use App\Session;

require '../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

     $loader = new FilesystemLoader(__DIR__.'/../templates');
     $twig = new Environment($loader, ['debug' => true]);
     $twig->addExtension(new DebugExtension());

    try {
        echo (new Router($twig))->run();
    } catch (Exception $e) {}

    if (Session::get('newsession','message','connection')) {
        Session::destroyMsg();
    } elseif (Session::get('newsession','message','deconnection')) {
        Session::destroyMsg();
    } elseif (Session::get('newsession','message','update_user')) {
        Session::destroyMsg();
    } elseif (Session::get('newsession','message','moderation')) {
        Session::destroyMsg();
    } elseif (Session::get('newsession','message','update_comment')) {
        Session::destroyMsg();
    } elseif (Session::get('newsession','message','article_update')) {
        Session::destroyMsg();
    } elseif (Session::get('newsession','add_article')) {
        Session::destroyMsg();
    }