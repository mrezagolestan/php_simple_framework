<?php

namespace Core\Facade;

use Core\Request\RequestMethod;
use Core\Routing\HTTPRouting;

class Route
{
    public static function get(string $matchURI, string $controller, string $method, bool $auth = false)
    {
        app()->resolve(HTTPRouting::class)->addRoute(RequestMethod::GET, $matchURI, $controller, $method, $auth);
    }

    public static function post(string $matchURI, string $controller, string $method, bool $auth = false)
    {
        app()->resolve(HTTPRouting::class)->addRoute(RequestMethod::POST, $matchURI, $controller, $method, $auth);
    }
}