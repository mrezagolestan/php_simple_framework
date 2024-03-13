<?php

namespace Core\Kernel;

use Core\Request\RequestInterface;

interface KernelInterface
{
    public function response(RequestInterface $request);

}