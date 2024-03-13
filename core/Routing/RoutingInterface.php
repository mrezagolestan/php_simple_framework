<?php

namespace Core\Routing;

use Core\Request\RequestInterface;
use Core\Request\RequestMethod;
use Core\Routing\HTTP\CallVO;

interface RoutingInterface
{
    public function addRoute(RequestMethod $requestMethod, string $requestURI, string $controller,
                             string        $controllerMethod, bool $auth);

    public function matchRoute(RequestInterface $request): CallVO;
}