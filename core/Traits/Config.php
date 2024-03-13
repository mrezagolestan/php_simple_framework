<?php

namespace Core\Traits;
trait Config
{
    public function loadConfig()
    {
        global $config;
        $config = json_decode(file_get_contents(APP_DIR . 'config.json'));
    }
}