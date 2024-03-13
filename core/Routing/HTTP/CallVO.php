<?php

namespace Core\Routing\HTTP;

use Core\Request\RequestMethod;

// HTTP Router Call Value Object
// ** tips: it's not a fully Value Object (able to add method arguments after construction once)
class CallVO
{
    private ?array $controllerMethodParameters = null;

    public function __construct(
        private readonly RequestMethod $method,
        private readonly string        $controller,
        private readonly string        $controllerMethod,
        private readonly bool          $auth = false,
    )
    {
    }

    public function getMethod(): RequestMethod
    {
        return $this->method;
    }

    public function getController(): string
    {
        return $this->controller;
    }

    public function getControllerMethod(): string
    {
        return $this->controllerMethod;
    }

    public function getControllerMethodParametes(): array
    {
        return $this->controllerMethodParameters;
    }

    public function setControllerMethodParametes($parameters): void
    {
        if (is_null($this->controllerMethodParameters)) {
            $this->controllerMethodParameters = $parameters;
        } else {
            throw new \Exception("Controller Method Argument List cannot get overrided");
        }
    }

    public function getAuth(): bool
    {
        return $this->auth;
    }
}