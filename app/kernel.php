<?php

use Core\Request\RequestInterface;
use Core\Request\Request;
use Core\Kernel\KernelInterface;
use Core\Kernel\HTTPKernel;
use Core\Routing\HTTPRouting;
use Core\Utils\Database\DBInterface;
use Core\Utils\Database\MySQL;
use Core\Request\MockRequest;
use Core\Response\ResponseInterface;
use Core\Response\Response;
use Core\Utils\Auth\AuthInterface;
use Core\Utils\Auth\Auth;
use Core\Utils\Auth\MockAuth;

/*
 * array structure
 * 0 = Abstract
 * 1 = Concrete
 * 2 = Should Bind Singleton ?
 */
return [
    'http' => [
        [KernelInterface::class, HTTPKernel::class],
        [RequestInterface::class, Request::class],
        [ResponseInterface::class, Response::class],
        [HTTPRouting::class, HTTPRouting::class, true],
        [DBInterface::class, function () {
            return new MySQL(
                env('DB_CONNECTION'),
                env('DB_HOST'),
                env('DB_PORT'),
                env('DB_DATABASE'),
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            );
        }, true],
        [AuthInterface::class, Auth::class, true],
    ],
    'http_testing' => [
        [KernelInterface::class, HTTPKernel::class],
        [RequestInterface::class, MockRequest::class],
        [ResponseInterface::class, Response::class],
        [HTTPRouting::class, HTTPRouting::class, true],
        [DBInterface::class, function () {
            return new MySQL(
                env('DB_CONNECTION'),
                env('TEST_DB_HOST'),
                env('TEST_DB_PORT'),
                env('DB_DATABASE'),
                env('DB_USERNAME'),
                env('DB_PASSWORD')
            );
        }, true],
        [AuthInterface::class, MockAuth::class, true],
    ],
    'termination_scripts' => [
        'http' => function () {
            // do nothing
        },
        'http_testing' => function () {
            app()->resolve(AuthInterface::class)->logout();
        },
    ],
];