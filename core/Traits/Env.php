<?php

namespace Core\Traits;

trait Env
{
    public function loadEnv()
    {
        $env = parse_ini_file(BASE_DIR . '.env');
        $_ENV = array_merge($_ENV, $env);
    }
}