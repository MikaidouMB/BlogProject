<?php

namespace Framework;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router
{

//    private $modules = [];
//
//    /**
//     * Router constructor.
//     * @param string $modules Liste des modules à charger
//     */
//    public function __construct(array $modules)
//    {
//        foreach ($modules as $module){
//            $this->modules[] = new $module();
//        }
//    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();

        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                ->withStatus(301)
                ->withHeader('location', substr($uri, 0, -1));
        }
        if ($uri === '/public/blog') {
            return new Response(200, [], '<h1>Bienvenue sur le blog</h1>');
        }
        return new Response(404, [], '<h1>Error 404</h1>');

    }
}
