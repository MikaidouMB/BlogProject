<?php

use Framework\AppController;
use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use function Http\Response\send;

require '../vendor/autoload.php';

$app = new Router();
$demo = array();
$response = $app->run(ServerRequest::fromGlobals());
send($response);


//$loader = new FilesystemLoader('../templates');
//$twig = new Environment($loader, [
 //   'debug' => true,
//]);
//$appController = new AppController();
//echo $appController->index($twig);