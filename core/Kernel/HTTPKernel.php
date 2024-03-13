<?php

namespace Core\Kernel;

use Core\Request\RequestInterface;
use Core\Response\ResponseInterface;
use Core\Routing\HTTPRouting;
use Core\Utils\Auth\AuthInterface;

class HTTPKernel implements KernelInterface
{
    private ?ResponseInterface $response = null;

    public function response(RequestInterface $request)
    {
        require APP_DIR . 'routes.php';


        try {
            $matchedRouteCallVO = app()->resolve(HTTPRouting::class)->matchRoute($request);
            //check authentication
            if ($matchedRouteCallVO->getAuth() && !$this->checkAuth()) {
                return $this;
            }
            //call
            ob_start();
            $controller = app()->resolve($matchedRouteCallVO->getController());

            $method = $matchedRouteCallVO->getControllerMethod();
            $parameters = $matchedRouteCallVO->getControllerMethodParametes();
            $this->response = $controller->$method(...$parameters);

            //prepend controller output to response body
            $this->response->setBody(ob_get_contents() . $this->response->getBody());
            ob_end_clean();
            return $this;
        } catch (\throwable $e) {
            $this->response = app()->resolve(ResponseInterface::class)
                ->setBody($e->getMessage())
                ->setStatus($e->getCode());
            return $this;
        }
    }

    public function flush()
    {
        if ($this->response->getStatus() == 302) {
            header('Location: ' . $this->response->getBody());
            exit(1);
        } else {
            http_response_code($this->response->getStatus());
            echo $this->response->getBody();
            exit(1);
        }
    }

    public function get(): ?ResponseInterface
    {
        return $this->response;
    }

    private function checkAuth(): bool
    {
        if (app()->resolve(AuthInterface::class)->authenticated()) {
            return true;
        } else {
            setFlashMessage('danger', 'for access this page, first Login');
            $this->response = app()
                ->resolve(\Core\Response\ResponseInterface::class)
                ->setBody(config()->auth->login)
                ->setStatus(302);
            return false;
        }
    }
}