<?php

namespace Core\Exceptions;

class NotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct("404 Not Found", 404);
    }
}