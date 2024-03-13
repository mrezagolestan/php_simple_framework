<?php

namespace Core\Routing;

use Core\Exceptions\MethodNotAllowedException;
use Core\Exceptions\NotFoundException;
use Core\Request\RequestInterface;
use Core\Request\RequestMethod;
use Core\Routing\HTTP\CallVO;

class HTTPRouting implements RoutingInterface
{

    private array $routes = [];

    public function addRoute(RequestMethod $requestMethod, string $requestURI, string $controller, string $controllerMethod, bool $auth)
    {

        $uris = $this->makeURIArray($requestURI);
        $last = array_key_last($uris);

        $baseArray = &$this->routes;
        foreach ($uris as $key => $uri) {
            $routeKey = str_starts_with($uri, ':') ? 'vars' : $uri;

            if ($key == $last) {
                $baseArray[$routeKey]['_call'][$requestMethod->name] = new CallVO(
                    $requestMethod,
                    $controller,
                    $controllerMethod,
                    $auth
                );
            } else {
                if (!isset($baseArray[$routeKey])) {
                    $baseArray[$routeKey] = [];
                }
                $baseArray = &$baseArray[$routeKey];
            }
        }
    }

    public function matchRoute(RequestInterface $request): CallVO
    {
        $uris = $this->makeURIArray($request->getURI());
        $last = array_key_last($uris);
        $parameters = [];

        $baseArray = &$this->routes;
        foreach ($uris as $key => $uri) {
            $routeKey = isset($baseArray[$uri]) ? $uri : 'vars';

            if (!isset($baseArray[$routeKey])) {
                throw new NotFoundException();
            }

            if ($routeKey == 'vars'){
                //extract Parameters
                $parameters[] = $uri;
            }
            $baseArray = &$baseArray[$routeKey];
        }

        if (!isset($baseArray['_call'])) {
            throw new NotFoundException();

        }

        if (!isset($baseArray['_call'][$request->getMethod()->name])) {
            throw new MethodNotAllowedException();
        }

        $baseArray['_call'][$request->getMethod()->name]->setControllerMethodParametes($parameters);

        return $baseArray['_call'][$request->getMethod()->name];
    }

    private function makeURIArray(string $requestURI)
    {
        $uris = explode('/', $requestURI);

        //remove Null Elements
        foreach ($uris as $key => $uri) {
            if (empty($uri)) {
                unset($uris[$key]);
            }
        }

        if (count($uris) == 0) {
            $uris = ['index'];
        }
        return $uris;
    }
}