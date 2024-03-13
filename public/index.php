<?php
require '../core/bootstrap.php';

use Core\Kernel\KernelInterface;
use Core\Request\RequestInterface;

//Bind Important
$app->bindFromKernelConfig('http');

//Make Kernel
$kernel = $app->resolve(KernelInterface::class);

//Make Request
$request = $app->resolve(RequestInterface::class);

//Get Response From Kernel
$response = $kernel->response($request);

//Terminate
$app->terminateFromKernelConfig('http');

//Send Response
$response->flush();
