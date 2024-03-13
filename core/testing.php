<?php
require 'bootstrap.php';

use Core\Kernel\KernelInterface;
use Core\Request\RequestInterface;

//Bind Important
$app->bindFromKernelConfig('http_testing');
