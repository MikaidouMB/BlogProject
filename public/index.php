<?php

use App\Router;
use Symfony\Component\Dotenv\Dotenv;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require '../vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(__DIR__.'/../.env');

     $loader = new FilesystemLoader(__DIR__.'/../templates');
       $twig = new Environment($loader, ['debug' => true]);

 echo (new Router($twig))->run();
