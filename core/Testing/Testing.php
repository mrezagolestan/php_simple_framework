<?php

namespace Core\Testing;

use Core\Kernel\KernelInterface;
use Core\Request\RequestInterface;
use Core\Request\RequestMethod;
use Core\Response\ResponseInterface;
use Core\Utils\Auth\AuthInterface;

trait Testing
{
    public function get(string $uri, array $parameters = [])
    {
        return $this->request(RequestMethod::GET, $uri, $parameters);
    }

    public function post(string $uri, array $parameters = [])
    {
        return $this->request(RequestMethod::POST, $uri, $parameters);
    }

    public function actAs(int $userId)
    {
        app()->resolve(AuthInterface::class)->auth($userId);
    }

    private function request(RequestMethod $method, string $uri, array $parameters = []): ResponseInterface
    {
        global $kernel;

        //Make Request
        $request = app()->resolve(RequestInterface::class);
        $request->setMethod($method);
        $request->setURI($uri);
        $request->setParameters($parameters);

        //Make Kernel
        $kernel = app()->resolve(KernelInterface::class);

        //Get Response
        $response = $kernel->response($request);

//        if (empty($response)){
//            dd($response);
//        }

        //Terminate
        app()->terminateFromKernelConfig('http_testing');

        //Get Response
        return $response->get();
    }
}