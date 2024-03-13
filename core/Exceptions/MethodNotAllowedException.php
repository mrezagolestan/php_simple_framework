<?php

namespace Core\Exceptions;

class MethodNotAllowedException extends \Exception
{
    public function __construct()
    {
        parent::__construct("405 Method Not Allowed", 405);
    }
}