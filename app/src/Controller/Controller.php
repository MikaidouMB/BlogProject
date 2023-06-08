<?php
namespace App\Controller;

use App\Session;
use App\Model\Input;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

abstract class Controller
{
    protected Environment $twig;
    private Input $input;

    public function __construct(Environment $twig, Input $input)
    {
        $this->twig = $twig;
        $this->input = $input;

        if (!session_id()) {
            Session::start();
        }
        if (session_id()) {
            $this->twig->addGlobal('session',Session::setSession('newsession'));
        }
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