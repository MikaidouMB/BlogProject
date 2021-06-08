<?php


namespace App\Controller;


use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class Controller

{
    protected Environment $twig;
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function render(string $path, array $params=[]): string
    {
        try {
            return $this->twig->render($path, $params);
            } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage();
        }
    }
}