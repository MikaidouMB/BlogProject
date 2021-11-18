<?php

use App\Router;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

require '../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

     $loader = new FilesystemLoader(__DIR__.'/../templates');
     $twig = new Environment($loader, ['debug' => true]);
     $twig->addExtension(new DebugExtension());

    try {
        echo (new Router($twig))->run();
    } catch (Exception $e) {}

    if (isset($_SESSION['newsession']['confirmation'])){
        unset($_SESSION['newsession']['confirmation']);
    }
    elseif (isset($_SESSION['newsession']['deconnection'])){
        unset($_SESSION['newsession']['deconnection']);
    }
    elseif (isset($_SESSION['newsession']['inscription'])){
        unset($_SESSION['newsession']['inscription']);
    }
    elseif (isset($_SESSION['newsession']['ajout'])){
        unset($_SESSION['newsession']['ajout']);
    }
    elseif (isset($_SESSION['newsession']['moderation'])){
        unset($_SESSION['newsession']['moderation']);
    }
    elseif (isset($_SESSION['newsession']['valide'])){
        unset($_SESSION['newsession']['valide']);
    }
    elseif (isset($_SESSION['newsession']['article_update'])){
        unset($_SESSION['newsession']['article_update']);
    }
    elseif (isset($_SESSION['newsession']['update_comment'])){
        unset($_SESSION['newsession']['update_comment']);
    }
    elseif (isset($_SESSION['newsession']['update_user'])){
        unset($_SESSION['newsession']['update_user']);
    }
